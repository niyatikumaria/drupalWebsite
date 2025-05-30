<?php

namespace Drupal\customer_feedback\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class FeedbackTypeSettingsForm extends ConfigFormBase {

  public function getFormId() {
    return 'customer_feedback_type_settings';
  }

  protected function getEditableConfigNames() {
    return ['customer_feedback.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('customer_feedback.settings');

    $form['feedback_types'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Feedback Types'),
      '#description' => $this->t('Enter one feedback type per line.'),
      '#default_value' => $config->get('feedback_types') ?? '',
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('customer_feedback.settings')
      ->set('feedback_types', $form_state->getValue('feedback_types'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
