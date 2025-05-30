<?php

namespace Drupal\customer_feedback;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

/**
 * Defines the view builder for CustomerFeedback entity.
 */
class CustomerFeedbackViewBuilder extends EntityViewBuilder
{

    /**
     * {@inheritdoc}
     */
    public function view(EntityInterface $entity, $view_mode = 'full', $langcode = null)
    {
        $build = parent::view($entity, $view_mode, $langcode);

        $build['name'] = [
            '#type' => 'markup',
            '#markup' => '<p><strong>Name:</strong> ' . $entity->get('name')->value . '</p>',
        ];
        $build['email'] = [
            '#type' => 'markup',
            '#markup' => '<p><strong>Email:</strong> ' . $entity->get('email')->value . '</p>',
        ];
        $build['phone'] = [
            '#type' => 'markup',
            '#markup' => '<p><strong>Phone:</strong> ' . $entity->get('phone')->value . '</p>',
        ];
        $build['address'] = [
            '#type' => 'markup',
            '#markup' => '<p><strong>Address:</strong> ' . $entity->get('address')->value . '</p>',
        ];

        $build['feedback_type']=[
            '#type'=>'markup',
            '#markup' => '<p><strong> Feedback Type: </strong>' . $entity->get('feedback_type')->value . '</p>',
        ];

        $build['message'] = [
            '#type' => 'markup',
            '#markup' => '<p><strong>Message:</strong> ' . $entity->get('message')->value . '</p>',
        ];
        $build['status'] = [
            '#type' => 'markup',
            '#markup' => '<p><strong>Status:</strong> ' . $entity->get('status')->value . '</p>',
        ];

        return $build;
    }

}
