<?php

namespace Drupal\news\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsImportForm extends FormBase {

  protected $fileSystem;
  protected $entityTypeManager;
  protected $messenger;

  public function __construct(FileSystemInterface $file_system, EntityTypeManagerInterface $entity_type_manager, MessengerInterface $messenger) {
    $this->fileSystem = $file_system;
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file_system'),
      $container->get('entity_type.manager'),
      $container->get('messenger')
    );
  }

  public function getFormId() {
    return 'news_import_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['file_type'] = [
      '#type' => 'select',
      '#title' => $this->t('File Type'),
      '#options' => [
        'csv' => $this->t('CSV'),
        'pdf' => $this->t('PDF'),
      ],
      '#required' => TRUE,
    ];

    $form['file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Import File'),
      '#description' => $this->t('Upload a CSV or PDF file containing news data'),
      '#upload_validators' => [
        'FileExtension' => ['csv', 'pdf'],
      ],
      '#upload_location' => 'public://news_imports/',
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Import News'),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $file = $form_state->getValue('file');
    if (empty($file)) {
      $form_state->setErrorByName('file', $this->t('Please upload a file.'));
      return;
    }

    $file_entity = File::load(reset($file));
    if (!$file_entity) {
      $form_state->setErrorByName('file', $this->t('Uploaded file could not be loaded.'));
      return;
    }

    $file_extension = strtolower(pathinfo($file_entity->getFilename(), PATHINFO_EXTENSION));
    $file_type = $form_state->getValue('file_type');

    if (($file_type === 'csv' && $file_extension !== 'csv') ||
        ($file_type === 'pdf' && $file_extension !== 'pdf')) {
      $form_state->setErrorByName('file', $this->t('The uploaded file type does not match the selected file type.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $file_type = $form_state->getValue('file_type');
    $fid = reset($form_state->getValue('file'));
    $file = File::load($fid);

    if (!$file) {
      $this->messenger->addError($this->t('Uploaded file not found.'));
      return;
    }

    $file_path = $this->fileSystem->realpath($file->getFileUri());

    // Log start of import.
    \Drupal::logger('news')->info('Starting news import from @file (type: @type)', [
      '@file' => $file_path,
      '@type' => $file_type,
    ]);

    try {
      if ($file_type === 'csv') {
        $this->importFromCsv($file_path);
      }
      else {
        $this->importFromPdf($file_path);
      }
      $this->messenger->addStatus($this->t('News imported successfully.'));
      \Drupal::logger('news')->info('News import completed successfully.');
    }
    catch (\Exception $e) {
      $this->messenger->addError($this->t('Error during import: @error', ['@error' => $e->getMessage()]));
      \Drupal::logger('news')->error('Error during news import: @error', ['@error' => $e->getMessage()]);
    }
  }

  protected function importFromCsv($file_path) {
    if (($handle = fopen($file_path, 'r')) === FALSE) {
      throw new \Exception('Unable to open CSV file.');
    }

    // Skip header row.
    fgetcsv($handle);
    $imported = 0;

    while (($data = fgetcsv($handle)) !== FALSE) {
      // CSV columns expected:
      // title, author, category, description, place, time, end_time, highlight, status

      // Sanitize/validate individual fields as needed here.

      $node = Node::create([
        'type' => 'news',
        'title' => $data[0] ?? 'Untitled News',
        'field_author' => $data[1] ?? '',
        'field_description' => [
          'value' => $data[3] ?? '',
          'format' => 'full_html',
        ],
        'field_place' => $data[4] ?? '',
        'field_time' => !empty($data[5]) ? $data[5] : date('Y-m-d'),
        'field_end_time' => !empty($data[6]) ? $data[6] : NULL,
        'field_highlight' => !empty($data[7]) ? (bool)$data[7] : FALSE,
        'field_status' => isset($data[8]) ? (bool)$data[8] : TRUE,
        'status' => 1,
      ]);

      if (!empty($data[2])) {
        $term = $this->getOrCreateTerm($data[2]);
        $node->set('field_category', $term->id());
      }

      $node->save();
      $imported++;
    }

    fclose($handle);

    $this->messenger->addStatus($this->t('Imported @count news items.', ['@count' => $imported]));
  }

  protected function importFromPdf($file_path) {
    // Note: This is a simple placeholder.
    // Consider using a PDF parsing library to extract real content.

    $content = file_get_contents($file_path);
    $title = 'Imported News ' . date('Y-m-d H:i:s');
    $description = 'Content extracted from PDF file.';

    $node = Node::create([
      'type' => 'news',
      'title' => $title,
      'field_description' => [
        'value' => $description,
        'format' => 'full_html',
      ],
      'field_status' => TRUE,
      'status' => 1,
    ]);
    $node->save();
  }

  protected function getOrCreateTerm($name) {
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')
      ->loadByProperties(['name' => $name, 'vid' => 'news_category']);

    if (empty($terms)) {
      $term = Term::create([
        'name' => $name,
        'vid' => 'news_category',
      ]);
      $term->save();
      return $term;
    }

    return reset($terms);
  }
}
