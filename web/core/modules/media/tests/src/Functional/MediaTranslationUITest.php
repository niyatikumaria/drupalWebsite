<?php

declare(strict_types=1);

namespace Drupal\Tests\media\Functional;

use Drupal\Tests\content_translation\Functional\ContentTranslationUITestBase;
use Drupal\Tests\media\Traits\MediaTypeCreationTrait;

/**
 * Tests the Media Translation UI.
 *
 * @group media
 */
class MediaTranslationUITest extends ContentTranslationUITestBase {

  use MediaTypeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected $defaultCacheContexts = [
    'languages:language_interface',
    'session',
    'theme',
    'url.path',
    'url.query_args',
    'user.permissions',
    'user.roles:authenticated',
  ];

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'language',
    'content_translation',
    'media',
    'media_test_source',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    $this->entityTypeId = 'media';
    $this->bundle = 'test';
    parent::setUp();
    $this->doSetup();
  }

  /**
   * {@inheritdoc}
   */
  public function setupBundle(): void {
    $this->createMediaType('test', [
      'id' => $this->bundle,
      'queue_thumbnail_downloads' => FALSE,
    ]);
  }

  /**
   * {@inheritdoc}
   */
  protected function getTranslatorPermissions(): array {
    return array_merge(parent::getTranslatorPermissions(), [
      'administer media',
      'edit any test media',
    ]);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditorPermissions(): array {
    return ['administer media', 'create test media'];
  }

  /**
   * {@inheritdoc}
   */
  protected function getAdministratorPermissions(): array {
    return array_merge(parent::getAdministratorPermissions(), [
      'access administration pages',
      'administer media types',
      'access media overview',
      'administer languages',
    ]);
  }

  /**
   * {@inheritdoc}
   */
  protected function getNewEntityValues($langcode) {
    return [
      'name' => [['value' => $this->randomMachineName()]],
      'field_media_test' => [['value' => $this->randomMachineName()]],
    ] + parent::getNewEntityValues($langcode);
  }

}
