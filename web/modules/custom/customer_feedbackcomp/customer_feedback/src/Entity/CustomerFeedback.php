<?php

namespace Drupal\customer_feedback\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Customer Feedback entity.
 *
 * @ContentEntityType(
 *   id = "customer_feedback",
 *   label = @Translation("Customer Feedback"),
 *   base_table = "customer_feedback",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   admin_permission = "administer customer feedback entities",
 *   handlers = {
 *     "view_builder" = "Drupal\customer_feedback\CustomerFeedbackViewBuilder",
 *     "list_builder" = "Drupal\customer_feedback\CustomerFeedbackListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\customer_feedback\CustomerFeedbackAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\customer_feedback\Form\CustomerFeedbackForm",
 *       "edit" = "Drupal\customer_feedback\Form\CustomerFeedbackForm",
 *       "delete" = "Drupal\customer_feedback\Form\CustomerFeedbackDeleteForm"
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider"
 *     },
 *     "field_ui" = "Drupal\field_ui\Entity\Form\EntityDisplayForm"
 *   },
 *   links = {
 *     "canonical" = "/admin/content/customer-feedback/{customer_feedback}",
 *     "edit-form" = "/admin/content/customer-feedback/{customer_feedback}/edit",
 *     "delete-form" = "/admin/content/customer-feedback/{customer_feedback}/delete"
 *   }
 * )
 */
class CustomerFeedback extends ContentEntityBase {

  /**
   * Defines base fields for the Customer Feedback entity.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Required ID field.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setReadOnly(TRUE);

    // Required UUID field.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setReadOnly(TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setRequired(TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setRequired(TRUE);

    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone'));

    $fields['address'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Address'));

    $fields['message'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Message'));

    $fields['status'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Status'))
      ->setDefaultValue('pending')
      ->setSettings([
        'allowed_values' => [
          'pending' => 'Pending',
          'approved' => 'Approved',
          'rejected' => 'Rejected',
        ],
      ]);

    $fields['admin_notes'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Admin Notes'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'));

    return $fields;
  }
}
