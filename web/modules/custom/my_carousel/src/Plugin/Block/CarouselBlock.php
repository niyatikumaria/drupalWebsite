<?php
namespace Drupal\my_carousel\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "carousel_block",
 *   admin_label = @Translation("Bootstrap Carousel"),
 * )
 */
class CarouselBlock extends BlockBase {
  public function build() {
    return [
    '#type' => 'inline_template',
    '#template' => '
        <div id="homepageCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            {% for slide in slides %}
            <div class="carousel-item {{ loop.first ? "active" : "" }}">
                <img src="{{ slide.url }}" class="d-block w-100" alt="{{ slide.alt }}">
            </div>
            {% endfor %}
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homepageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homepageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    ',
    '#context' => [
        'slides' => [
        ['url' => 'https://testproject.ddev.site/sites/default/files/2025-06/Artmuseum.jpeg', 'alt' => 'Slide 1'],
        ['url' => 'https://testproject.ddev.site/sites/default/files/2025-06/farmermarket.jpg', 'alt' => 'Slide 2'],
        ['url' => 'https://testproject.ddev.site/sites/default/files/2025-06/librarry.jpg', 'alt' => 'Slide 3'],
        ['url' => 'https://testproject.ddev.site/sites/default/files/2025-06/marathon.jpg', 'alt' => 'Slide 4'],
        ['url' => 'https://testproject.ddev.site/sites/default/files/2025-06/park.webp', 'alt' => 'Slide 5'],
        ],
    ],
    '#attached' => [
        'library' => [
        'my_carousel/bootstrap',
        ],
    ],
    ];

  }
}