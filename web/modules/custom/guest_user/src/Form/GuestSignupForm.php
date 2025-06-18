<?php

namespace Drupal\guest_user\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;

class GuestSignupForm extends FormBase {

  public function getFormId() {
    return 'guest_signup_form';
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

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Sign Up'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');

    $connection = Database::getConnection();
    $exists = $connection->select('guest_user', 'g')
      ->fields('g', ['email'])
      ->condition('email', $email)
      ->execute()
      ->fetchField();

    if ($exists) {
      $this->messenger()->addError('Email already registered.');
    } else {
      $connection->insert('guest_user')
        ->fields([
          'name' => $name,
          'email' => $email,
          'is_verified' => 0,
        ])
        ->execute();

      $this->messenger()->addStatus('Signup successful. Please wait for admin approval.');
    }
  }
}
