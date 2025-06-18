<?php

namespace Drupal\guest_user\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class GuestLoginForm extends FormBase {

  public function getFormId() {
    return 'guest_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Log In'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');

    $connection = Database::getConnection();
    $record = $connection->select('guest_user', 'g')
      ->fields('g')
      ->condition('email', $email)
      ->execute()
      ->fetchAssoc();

    if (!$record) {
      $this->messenger()->addError('Email not found. Please sign up first.');
    } elseif (!$record['is_verified']) {
      $this->messenger()->addWarning('Your registration is pending admin approval.');
    } else {
      $this->messenger()->addStatus('Welcome, ' . $record['name'] . '! You are now logged in.');
      // Here you could set a session or redirect to a dashboard.
    }
  }
}
