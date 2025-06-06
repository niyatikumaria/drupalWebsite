<?php

declare(strict_types=1);

namespace Drupal\Tests\node\Functional;

use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;

/**
 * Tests the UI for controlling node revision behavior.
 *
 * @group node
 */
class NodeRevisionsUiTest extends NodeTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['block'];

  /**
   * @var \Drupal\user\Entity\User
   */
  protected $editor;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Create users.
    $this->editor = $this->drupalCreateUser([
      'administer nodes',
      'edit any page content',
      'view page revisions',
      'access user profiles',
    ]);
  }

  /**
   * Checks that unchecking 'Create new revision' works when editing a node.
   */
  public function testNodeFormSaveWithoutRevision(): void {
    $this->drupalLogin($this->editor);
    $node_storage = $this->container->get('entity_type.manager')->getStorage('node');

    // Set page revision setting 'create new revision'. This will mean new
    // revisions are created by default when the node is edited.
    $type = NodeType::load('page');
    $type->setNewRevision(TRUE);
    $type->save();

    // Create the node.
    $node = $this->drupalCreateNode();

    // Verify the checkbox is checked on the node edit form.
    $this->drupalGet('node/' . $node->id() . '/edit');
    $this->assertSession()->checkboxChecked('edit-revision');

    // Uncheck the create new revision checkbox and save the node.
    $edit = ['revision' => FALSE];
    $this->drupalGet('node/' . $node->id() . '/edit');
    $this->submitForm($edit, 'Save');

    // Load the node again and check the revision is the same as before.
    $node_storage->resetCache([$node->id()]);
    $node_revision = $node_storage->load($node->id(), TRUE);
    $this->assertEquals($node->getRevisionId(), $node_revision->getRevisionId(), "After an existing node is saved with 'Create new revision' unchecked, a new revision is not created.");

    // Verify the checkbox is checked on the node edit form.
    $this->drupalGet('node/' . $node->id() . '/edit');
    $this->assertSession()->checkboxChecked('edit-revision');

    // Submit the form without changing the checkbox.
    $edit = [];
    $this->drupalGet('node/' . $node->id() . '/edit');
    $this->submitForm($edit, 'Save');

    // Load the node again and check the revision is different from before.
    $node_storage->resetCache([$node->id()]);
    $node_revision = $node_storage->load($node->id());
    $this->assertNotEquals($node->getRevisionId(), $node_revision->getRevisionId(), "After an existing node is saved with 'Create new revision' checked, a new revision is created.");
  }

  /**
   * Checks HTML double escaping of revision logs.
   */
  public function testNodeRevisionDoubleEscapeFix(): void {
    $this->drupalLogin($this->editor);
    $nodes = [];

    // Create the node.
    $node = $this->drupalCreateNode();

    $username = [
      '#theme' => 'username',
      '#account' => $this->editor,
    ];
    $editor = \Drupal::service('renderer')->renderInIsolation($username);

    // Get original node.
    $nodes[] = clone $node;

    // Create revision with a random title and body and update variables.
    $node->title = $this->randomMachineName();
    $node->body = [
      'value' => $this->randomMachineName(32),
      'format' => filter_default_format(),
    ];
    $node->setNewRevision();
    $revision_log = 'Revision <em>message</em> with markup.';
    $node->revision_log->value = $revision_log;
    $node->save();
    // Make sure we get revision information.
    $node = Node::load($node->id());
    $nodes[] = clone $node;

    $this->drupalGet('node/' . $node->id() . '/revisions');

    // Assert the old revision message.
    $date = $this->container->get('date.formatter')->format($nodes[0]->revision_timestamp->value, 'short');
    $url = new Url('entity.node.revision', ['node' => $nodes[0]->id(), 'node_revision' => $nodes[0]->getRevisionId()]);
    $this->assertSession()->responseContains(Link::fromTextAndUrl($date, $url)->toString() . ' by ' . $editor);

    // Assert the current revision message.
    $date = $this->container->get('date.formatter')->format($nodes[1]->revision_timestamp->value, 'short');
    $this->assertSession()->responseContains($nodes[1]->toLink($date)->toString() . ' by ' . $editor . '<p class="revision-log">' . $revision_log . '</p>');
  }

  /**
   * Checks the Revisions tab.
   */
  public function testNodeRevisionsTabWithDefaultRevision(): void {
    $this->drupalLogin($this->editor);

    // Create the node.
    $node = $this->drupalCreateNode();
    $storage = \Drupal::entityTypeManager()->getStorage($node->getEntityTypeId());

    // Create a new revision based on the default revision.
    // Revision 2.
    $node = $storage->load($node->id());
    $node->setNewRevision(TRUE);
    $node->save();

    // Revision 3.
    $node = $storage->load($node->id());
    $node->setNewRevision(TRUE);
    $node->save();

    // Revision 4.
    // Trigger translation changes in order to show the revision.
    $node = $storage->load($node->id());
    $node->setTitle($this->randomString());
    $node->isDefaultRevision(FALSE);
    $node->setNewRevision(TRUE);
    $node->save();

    // Revision 5.
    $node = $storage->load($node->id());
    $node->isDefaultRevision(FALSE);
    $node->setNewRevision(TRUE);
    $node->save();

    $node_id = $node->id();

    $this->drupalGet('node/' . $node_id . '/revisions');

    // Verify that the latest affected revision having been a default revision
    // is displayed as the current one.
    $this->assertSession()->linkByHrefNotExists('/node/' . $node_id . '/revisions/1/revert');
    // The site may be installed in a subdirectory, so check if the URL is
    // contained in the retrieved one.
    $this->assertSession()->elementAttributeContains('xpath', '//tr[contains(@class, "revision-current")]/td/a[1]', 'href', '/node/1');

    // Verify that the default revision can be an older revision than the latest
    // one.
    // Assert that the revisions with translations changes are shown.
    $this->assertSession()->linkByHrefExists('/node/' . $node_id . '/revisions/4/revert');

    // Assert that the revisions without translations changes are filtered out:
    // 2, 3 and 5.
    $this->assertSession()->linkByHrefNotExists('/node/' . $node_id . '/revisions/2/revert');
    $this->assertSession()->linkByHrefNotExists('/node/' . $node_id . '/revisions/3/revert');
    $this->assertSession()->linkByHrefNotExists('/node/' . $node_id . '/revisions/5/revert');
  }

  /**
   * Checks the Revisions tab.
   *
   * Tests two 'Revisions' local tasks are not added by both Node and
   * VersionHistoryLocalTasks.
   *
   * This can be removed after 'entity.node.version_history' local task is
   * removed by https://www.drupal.org/project/drupal/issues/3153559.
   *
   * @covers node_local_tasks_alter
   */
  public function testNodeDuplicateRevisionsTab(): void {
    $this->drupalPlaceBlock('local_tasks_block');
    $this->drupalLogin($this->editor);

    $node = $this->drupalCreateNode();
    $this->drupalGet($node->toUrl('edit-form'));

    // There must be exactly one 'Revisions' local task.
    $xpath = $this->assertSession()->buildXPathQuery('//a[contains(@href, :href)]', [':href' => $node->toUrl('version-history')->toString()]);
    $this->assertSession()->elementsCount('xpath', $xpath, 1);
  }

  /**
   * Tests the node revisions page is cacheable by dynamic page cache.
   */
  public function testNodeRevisionsCacheability(): void {
    $this->drupalLogin($this->editor);
    $node = $this->drupalCreateNode();
    // Admin paths are always uncacheable by dynamic page cache, swap node
    // to non admin theme to test cacheability.
    $this->config('node.settings')->set('use_admin_theme', FALSE)->save();
    \Drupal::service('router.builder')->rebuild();
    $this->drupalGet($node->toUrl('version-history'));
    $this->assertSession()->responseHeaderEquals('X-Drupal-Dynamic-Cache', 'MISS');
    $this->drupalGet($node->toUrl('version-history'));
    $this->assertSession()->responseHeaderEquals('X-Drupal-Dynamic-Cache', 'HIT');
  }

}
