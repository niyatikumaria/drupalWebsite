<?php

namespace Drupal\graph_input\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;

/**
 * Provides a form for generating charts based on all content types.
 */
class GraphInputForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'graph_input_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Chart type selection
    $form['chart_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Chart Type'),
      '#options' => [
        'bar' => $this->t('Bar Chart'),
        'line' => $this->t('Line Chart'),
        'pie' => $this->t('Pie Chart'),
      ],
      '#default_value' => 'bar',
    ];

    // Submit button
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Generate Graph'),
      '#attributes' => [
        'class' => ['button--primary'],
      ],
    ];

    // Display chart if available
    if ($form_state->get('chart_data_valid') && $form_state->get('chart_data')) {
      $chart_data = $form_state->get('chart_data');
      $chart_type = $form_state->get('chart_type') ?? 'bar';

      $form['chart_container'] = [
        '#type' => 'container',
        '#attributes' => ['id' => 'chart-container'],
        '#weight' => 100,
      ];

      $form['chart_container']['chart'] = [
        '#type' => 'html_tag',
        '#tag' => 'canvas',
        '#attributes' => [
          'id' => 'myChart',
          'width' => '600',
          'height' => '400',
          'class' => ['chart-canvas'],
        ],
        '#attached' => [
          'library' => ['graph_input/graph_input'],
          'drupalSettings' => [
            'graph_input' => [
              'data' => $chart_data,
              'chartType' => $chart_type,
            ],
          ],
        ],
      ];
    }

    // Reset button
    $form['reset'] = [
      '#type' => 'submit',
      '#value' => $this->t('Reset'),
      '#submit' => ['::resetForm'],
      '#limit_validation_errors' => [],
      '#attributes' => [
        'class' => ['button--danger'],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // No need to validate content types anymore
    $form_state->set('chart_data_valid', TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $chart_data = [];

    // Get all content types
    $content_types = NodeType::loadMultiple();

    foreach ($content_types as $type_id => $content_type) {
      $count = $this->getNodeCountByType($type_id);
      $chart_data['labels'][] = $content_type->label();
      $chart_data['data'][] = $count;
    }

    $form_state->set('chart_data', $chart_data);
    $form_state->set('chart_type', $form_state->getValue('chart_type'));
    $form_state->setRebuild(TRUE);
  }

  /**
   * Get the count of nodes for a specific content type.
   */
  protected function getNodeCountByType($type_id) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', $type_id)
      ->accessCheck(FALSE);
    return $query->count()->execute();
  }

  /**
   * Resets the form to its initial state.
   */
  public function resetForm(array &$form, FormStateInterface $form_state) {
    $form_state->set('chart_data', NULL);
    $form_state->set('chart_data_valid', FALSE);
    $form_state->setRebuild(FALSE);
    $form_state->setRedirect('<current>');
  }
}
