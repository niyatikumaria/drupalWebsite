<?php

namespace Drupal\news\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new NewsController.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Lists news articles with scheduled visibility.
   *
   * @return array
   *   A render array.
   */
  public function list() {
    try {
      // Use UTC timezone for consistent comparisons
      $now = DrupalDateTime::createFromTimestamp(time(), 'UTC')->format('Y-m-d\TH:i:s');
      
      $query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->accessCheck(TRUE)
        ->condition('type', 'news')
        ->condition('status', 1);

      // Add date conditions only if fields exist
      $definitions = $this->entityTypeManager->getDefinition('node')->get('field_storage_definitions');
      
      if (isset($definitions['field_time'])) {
        $query->condition('field_time', $now, '<=');
      }
      
      if (isset($definitions['field_end_time'])) {
        $query->condition('field_end_time', $now, '>=');
      }

      $nids = $query
        ->sort('field_time', 'DESC')
        ->pager(5)
        ->execute();

      $nodes = Node::loadMultiple($nids);

      return [
        '#theme' => 'news_list',
        '#news_items' => $nodes,
        '#pager' => [
          '#type' => 'pager',
          '#quantity' => 5,
        ],
        '#cache' => [
          'tags' => ['node_list'],
          'contexts' => ['timezone'],
        ],
      ];

    } catch (\Exception $e) {
      \Drupal::logger('news')->error('News listing error: @error', ['@error' => $e->getMessage()]);
      return [
        '#markup' => $this->t('Temporarily unable to load news listings.'),
        '#cache' => [
          'tags' => ['node_list'],
        ],
      ];
    }
  }

  /**
   * Displays a single news article, only if within scheduled visibility time.
   *
   * @param int $nid
   *   The node ID.
   *
   * @return array
   *   A render array.
   */
  public function detail($nid) {
    try {
      $node = Node::load($nid);

      if (!$node || $node->bundle() !== 'news') {
        throw new \Exception('News node not found');
      }

      // Use UTC timezone for consistent comparisons
      $now = DrupalDateTime::createFromTimestamp(time(), 'UTC')->format('Y-m-d\TH:i:s');
      $start = $node->get('field_time')->value;
      $end = $node->get('field_end_time')->value;

      // Validate date fields exist
      if (empty($start) || empty($end)) {
        throw new \Exception('Missing date fields');
      }

      // Check visibility window
      if ($start <= $now && $now <= $end) {
        $view_builder = $this->entityTypeManager->getViewBuilder('node');
        $build = $view_builder->view($node, 'full');
        $build['#cache']['tags'] = $node->getCacheTags();
        $build['#cache']['contexts'] = ['timezone'];
        return $build;
      }

      return [
        '#markup' => $this->t('This news article is no longer available.'),
        '#cache' => [
          'tags' => $node->getCacheTags(),
          'contexts' => ['timezone'],
        ],
      ];

    } catch (\Exception $e) {
      \Drupal::logger('news')->error('News detail error: @error', ['@error' => $e->getMessage()]);
      return [
        '#markup' => $this->t('News not available.'),
        '#cache' => [
          'tags' => ['node_list'],
        ],
      ];
    }
  }
}