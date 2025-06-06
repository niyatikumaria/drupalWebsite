<?php

namespace Drupal\news\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsController extends ControllerBase {

  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Shows all news articles (no categories displayed).
   */
  public function list() {
    try {
      $now = DrupalDateTime::createFromTimestamp(time(), 'UTC')->format('Y-m-d\TH:i:s');

      $query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->accessCheck(TRUE)
        ->condition('type', 'news')
        ->condition('status', 1)
        ->condition('field_time', $now, '<=')
        ->condition('field_end_time', $now, '>=')
        ->sort('field_time', 'DESC')
        ->pager(10);

      $nodes = Node::loadMultiple($query->execute());

      return [
        '#theme' => 'news_list',
        '#news_items' => $nodes,
        '#pager' => [
          '#type' => 'pager',
        ],
        '#cache' => [
          'tags' => ['node_list'],
          'contexts' => ['timezone'],
        ],
      ];

    } catch (\Exception $e) {
      $this->getLogger('news')->error('News listing error: @error', ['@error' => $e->getMessage()]);
      return [
        '#markup' => $this->t('Temporarily unable to load news listings.'),
        '#cache' => ['tags' => ['node_list']],
      ];
    }
  }

  /**
   * Shows only the category listing page.
   */
  public function categories() {
    try {
      $vocabularies = $this->entityTypeManager->getStorage('taxonomy_vocabulary')->loadMultiple();
      if (!isset($vocabularies['news_category'])) {
        throw new \Exception('Vocabulary "news_category" not found. Available vocabularies: ' . implode(', ', array_keys($vocabularies)));
      }

      $terms = $this->entityTypeManager->getStorage('taxonomy_term')
        ->loadByProperties(['vid' => 'news_category']);

      if (empty($terms)) {
        throw new \Exception('No terms found in "news_category" vocabulary');
      }

      $categories = [];
      foreach ($terms as $term) {
        if (!$term instanceof Term) {
          continue;
        }

        $categories[] = [
          'id' => $term->id(),
          'name' => $term->label(),
          'count' => $this->getCategoryCount($term->id()),
          'url' => $this->generateUrl('news.category_list', ['category' => $term->id()])
        ];
      }

      if (empty($categories)) {
        throw new \Exception('No valid categories could be processed');
      }

      return [
        '#theme' => 'news_category',
        '#categories' => $categories,
        '#cache' => [
          'tags' => ['taxonomy_term_list', 'taxonomy_vocabulary:news_category'],
        ],
      ];

    } catch (\Exception $e) {
      $this->getLogger('news')->error('Categories error: @error', ['@error' => $e->getMessage()]);
      return [
        '#markup' => $this->t('Unable to load news categories. Error details have been logged.'),
        '#cache' => ['tags' => ['taxonomy_term_list']],
      ];
    }
  }

  /**
   * Shows news for a specific category.
   */
  public function categoryList($category) {
    try {
      $term = $this->entityTypeManager->getStorage('taxonomy_term')->load($category);
      if (!$term) {
        throw new \Exception('Invalid category ID: ' . $category);
      }

      $now = DrupalDateTime::createFromTimestamp(time(), 'UTC')->format('Y-m-d\TH:i:s');

      $query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->accessCheck(TRUE)
        ->condition('type', 'news')
        ->condition('status', 1)
        ->condition('field_category', $category)
        ->condition('field_time', $now, '<=')
        ->condition('field_end_time', $now, '>=')
        ->sort('field_time', 'DESC')
        ->pager(10);

      $nodes = Node::loadMultiple($query->execute());

      return [
        '#theme' => 'news_category_list',
        '#news_items' => $nodes,
        '#category' => $term->label(),
        '#pager' => [
          '#type' => 'pager',
        ],
        '#cache' => [
          'tags' => ['node_list', 'taxonomy_term:' . $category],
          'contexts' => ['timezone', 'url'],
        ],
      ];

    } catch (\Exception $e) {
      $this->getLogger('news')->error('Category news error: @error', ['@error' => $e->getMessage()]);
      return [
        '#markup' => $this->t('Unable to load news for this category.'),
        '#cache' => ['tags' => ['node_list']],
      ];
    }
  }

  /**
   * Displays a single news article.
   */
  public function detail($nid) {
    try {
      $node = Node::load($nid);

      if (!$node || $node->bundle() !== 'news') {
        throw new \Exception('News node not found');
      }

      $now = DrupalDateTime::createFromTimestamp(time(), 'UTC')->format('Y-m-d\TH:i:s');
      $start = $node->get('field_time')->value;
      $end = $node->get('field_end_time')->value;

      if (empty($start) || empty($end)) {
        throw new \Exception('Missing date fields');
      }

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
      $this->getLogger('news')->error('News detail error: @error', ['@error' => $e->getMessage()]);
      return [
        '#markup' => $this->t('News not available.'),
        '#cache' => ['tags' => ['node_list']],
      ];
    }
  }

  /**
   * Gets count of published news in a category.
   */
  protected function getCategoryCount($tid) {
    $now = DrupalDateTime::createFromTimestamp(time(), 'UTC')->format('Y-m-d\TH:i:s');

    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->accessCheck(FALSE)
      ->condition('type', 'news')
      ->condition('status', 1)
      ->condition('field_category', $tid)
      ->condition('field_time', $now, '<=')
      ->condition('field_end_time', $now, '>=')
      ->count();

    return $query->execute();
  }

  /**
   * Generates a URL for a route with parameters.
   */
  protected function generateUrl($route_name, $parameters = []) {
    return \Drupal::urlGenerator()->generateFromRoute($route_name, $parameters);
  }

}
