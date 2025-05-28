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
      'message' => $form_state->getValue('message'),
      'status' => 'pending',
    ]);
    $feedback->save();

    $this->messenger()->addStatus($this->t('Thank you for your feedback!'));
    $form_state->setRedirect('<front>');
  }
}
