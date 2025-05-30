<?php

namespace Drupal\customer_feedback;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the CustomerFeedback entity.
 */
class CustomerFeedbackAccessControlHandler extends EntityAccessControlHandler
{

    /**
     * {@inheritdoc}
     */
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
    {
        switch ($operation) {
            case 'view':
                return AccessResult::allowedIfHasPermission($account, 'access customer feedback submissions');

            case 'edit':
            case 'delete':
                return AccessResult::allowedIfHasPermission($account, 'administer customer feedback');
        }

        return AccessResult::neutral();
    }

    /**
     * {@inheritdoc}
     */
    protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = null)
    {
        return AccessResult::allowedIfHasPermission($account, 'access customer feedback submissions');
    }
}
