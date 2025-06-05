namespace Drupal\news\Service;

use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Datetime\DrupalDateTime;

class NewsVisibilityService {
  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  public function updateVisibility() {
    $storage = $this->entityTypeManager->getStorage('node');
    $query = $storage->getQuery()
      ->condition('type', 'news')
      ->condition('status', 1)
      ->sort('field_time', 'DESC');
    
    $nids = $query->execute();
    $now = DrupalDateTime::createFromTimestamp(time())->format('Y-m-d\TH:i:s');
    
    foreach (Node::loadMultiple($nids) as $node) {
      $publish_time = $node->get('field_time')->value;
      if ($publish_time > $now) {
        $node->setUnpublished()->save();
      }
    }
  }
}
