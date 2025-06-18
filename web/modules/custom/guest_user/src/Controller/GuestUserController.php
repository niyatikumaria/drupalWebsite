<?php

namespace Drupal\guest_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class GuestUserController extends ControllerBase {

  public function adminPage() {
    $header = [
      'id' => $this->t('ID'),
      'name' => $this->t('Name'),
      'email' => $this->t('Email'),
      'is_verified' => $this->t('Verified'),
      'actions' => $this->t('Actions'),
    ];

    $rows = [];
    $connection = Database::getConnection();
    $results = $connection->select('guest_user', 'g')
      ->fields('g')
      ->execute();

    foreach ($results as $record) {
      $toggle_url = Url::fromRoute('guest_user.toggle_verify', ['id' => $record->id]);
      $toggle_link = Link::fromTextAndUrl(
        $record->is_verified ? $this->t('Unverify') : $this->t('Verify'),
        $toggle_url
      )->toString();

      $rows[] = [
        'id' => $record->id,
        'name' => $record->name,
        'email' => $record->email,
        'is_verified' => $record->is_verified ? $this->t('Yes') : $this->t('No'),
        'actions' => ['data' => ['#markup' => $toggle_link]],
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No guest users found.'),
    ];
  }

  public function toggleVerify($id) {
    $connection = Database::getConnection();
    $record = $connection->select('guest_user', 'g')
      ->fields('g', ['is_verified'])
      ->condition('id', $id)
      ->execute()
      ->fetchAssoc();

    if ($record) {
      $new_status = $record['is_verified'] ? 0 : 1;
      $connection->update('guest_user')
        ->fields(['is_verified' => $new_status])
        ->condition('id', $id)
        ->execute();

      \Drupal::messenger()->addStatus('User verification status updated.');
    }

    return new RedirectResponse(Url::fromRoute('guest_user.admin_page')->toString());
  }
}
