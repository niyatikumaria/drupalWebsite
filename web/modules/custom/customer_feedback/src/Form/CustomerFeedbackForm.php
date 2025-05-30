<?php

namespace Drupal\customer_feedback\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\customer_feedback\Entity\CustomerFeedback;

class CustomerFeedbackForm extends FormBase {

  public function getFormId() {
    return 'customer_feedback_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('customer_feedback.settings');
    $types_raw = $config->get('feedback_types') ?? '';
    $types_array = array_filter(array_map('trim', explode("\n", $types_raw)));

    $options = array_combine($types_array, $types_array);

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone'),
    ];

    $form['address'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Address'),
      '#rows' => 3,
    ];

    $form['feedback_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type of Feedback'),
      '#options' => $options,
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#rows' => 5,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit Feedback'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $feedback = CustomerFeedback::create([
      'name' => $form_state->getValue('name'),
      'email' => $form_state->getValue('email'),
      'phone' => $form_state->getValue('phone'),
      'address' => $form_state->getValue('address'),
      'feedback_type' => $form_state->getValue('feedback_type'),
      'message' => $form_state->getValue('message'),
      'status' => 'pending',
    ]);
    

    $feedback->save();
    \Drupal::logger('customer_feedback')->debug('<pre><code>' . print_r($feedback->toArray(), TRUE) . '</code></pre>');


    $this->messenger()->addStatus($this->t('Thank you for your feedback!'));
    $form_state->setRedirect('<front>');
  }
}
