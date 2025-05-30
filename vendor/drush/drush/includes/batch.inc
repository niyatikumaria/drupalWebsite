<?php

/**
 * @file
 *    Drush batch API.
 *
 * This file contains a fork of the Drupal Batch API that has been drastically
 * simplified and tailored to Drush's unique use case.
 *
 * The existing API is very targeted towards environments that are web accessible,
 * and would frequently attempt to redirect the user which would result in the
 * drush process being completely destroyed with no hope of recovery.
 *
 * While the original API does offer a 'non progressive' mode which simply
 * calls each operation in sequence within the current process, in most
 * implementations (D6), it would still attempt to redirect
 * unless very specific conditions were met.
 *
 * When operating in 'non progressive' mode, Drush would experience the problems
 * that the API was written to solve in the first place, specifically that processes
 * would exceed the available memory and exit with an error.
 *
 * Each major release of Drupal has also had slightly different implementations
 * of the batch API, and this provides a uniform interface to all of these
 * implementations.
 */

use Drupal\Core\Database\Database;
use Drupal\Core\Database\IntegrityConstraintViolationException;
use Drush\Drush;

/**
 * Process a Drupal batch by spawning multiple Drush processes.
 *
 * The batch system will process as many batch sets as possible until
 * the entire batch has been completed or 60% of the available memory
 * has been used.
 *
 * This function is a drop in replacement for the existing batch_process()
 * function of Drupal.
 *
 * @param string $command
 *   (optional) The command to call for the back end process. By default this will be
 *   the 'batch-process' command, but some commands will
 *   have special initialization requirements, and will need to define and
 *   use their own command.
 * @param array $args
 *   (optional)
 * @param array $options
 *   (optional)
 */
function drush_backend_batch_process($command = 'batch-process', $args = [], $options = []) {
  // Command line options to pass to the command.
  $options['u'] = \Drupal::currentUser()->id();
  return _drush_backend_batch_process($command, $args, $options);
}

/**
 * Process sets from the specified batch.
 *
 * This function is called by the worker process that is spawned by the
 * drush_backend_batch_process function.
 *
 * The command called needs to call this function after it's special bootstrap
 * requirements have been taken care of.
 *
 * @param int $id
 *   The batch ID of the batch being processed.
 *
 * @return bool|array
 *   A results array.
 */
function drush_batch_command($id) {
  include_once(DRUSH_DRUPAL_CORE . '/includes/batch.inc');
  return _drush_batch_command($id);
}

/**
 * Main loop for the Drush batch API.
 *
 * Saves a record of the batch into the database, and progressively call $command to
 * process the operations.
 *
 * @param command
 *    The command to call to process the batch.
 *
 * @return array
 *   A return array. The callers only care about the finished marker and an #abort on an operation.
 *
 */
function _drush_backend_batch_process($command = 'batch-process', $args = [], $options = []) {
  $result = NULL;

  $batch = &batch_get();

  if (isset($batch)) {
    $process_info = [
      'current_set' => 0,
    ];
    $batch += $process_info;

    // The batch is now completely built. Allow other modules to make changes
    // to the batch so that it is easier to reuse batch processes in other
    // environments.
    \Drupal::moduleHandler()->alter('batch', $batch);

    // Assign an arbitrary id: don't rely on a serial column in the 'batch'
    // table, since non-progressive batches skip database storage completely.
    /** @var \Drupal\Core\Batch\BatchStorageInterface $batch_storage */
    $batch_storage = \Drupal::service('batch.storage');
    if (method_exists($batch_storage, 'getId')) {
      try {
        $batch['id'] = $batch_storage->getId();
      }
      catch (IntegrityConstraintViolationException) {
        // @todo this is here to support the update path to deprecate
        // Connection::nextId(). Remove when Drupal 10.1 and lower is no longer
        // supported.
        $connection = \Drupal::database();
        $max_bid = (int) $connection->query('SELECT MAX([bid]) FROM {batch}')->fetchField();
        $batch['id'] = $max_bid + 1;
        $connection->insert('batch')
          ->fields([
            'bid' => $batch['id'],
            'timestamp' => \Drupal::time()->getRequestTime(),
            'token' => '',
            'batch' => NULL,
          ])
          ->execute();
      }
    }
    else {
      $batch['id'] = \Drupal::database()->nextId();
    }
    $args[] = $batch['id'];

    $batch['progressive'] = TRUE;

    // Move operations to a job queue. Non-progressive batches will use a
    // memory-based queue.
    foreach ($batch['sets'] as $key => $batch_set) {
      _batch_populate_queue($batch, $key);
    }

    // Store the batch.
    $batch_storage->create($batch);
    $finished = FALSE;

    while (!$finished) {
      $process = Drush::drush(Drush::aliasManager()->getSelf(), $command, $args, Drush::redispatchOptions() + ['strict' => 0]);
      // We already re-spawn when memory is low so no need for timeout.
      $process->setTimeout(null);
      // Suppress printing stdout since a JSON array is returned to us here.
      $process->run($process->showRealtime()->hideStdout());
      $result = $process->getOutputAsJson();
      $finished = !$process->isSuccessful() || (isset($result['drush_batch_process_finished']) && $result['drush_batch_process_finished'] === TRUE);
    }
  }

  // An attempt to clear the batch is performed in "_drush_batch_finished",
  // however when that is run in a separate process, static cache changes need
  // to be replayed.
  $batch = NULL;

  return $result;
}


/**
 * Initialize the batch command and call the worker function.
 *
 * Loads the batch record from the database and sets up the requirements
 * for the worker, such as registering the shutdown function.
 *
 * @param id
 *   The batch id of the batch being processed.
 *
 * @return bool|array
 *   A results array.
 */
function _drush_batch_command($id) {
  $batch = &batch_get();

  $data = Database::getConnection()->select('batch', 'b')
    ->fields('b', ['batch'])
    ->condition('bid', (int) $id)
    ->execute()
    ->fetchField();

  if ($data) {
    $batch = unserialize($data);
  }
  else {
    return FALSE;
  }

  if (!isset($batch['running'])) {
    $batch['running'] = TRUE;
  }

  // Register database update for end of processing.
  register_shutdown_function('_drush_batch_shutdown');

  if (_drush_batch_worker()) {
    return _drush_batch_finished();
  }
  else {
    return ['drush_batch_process_finished' => FALSE];
  }
}


/**
 * Process batch operations
 *
 * Using the current $batch process each of the operations until the batch
 * has been completed or 60% of the available memory for the process has been
 * reached.
 */
function _drush_batch_worker() {
  $batch = &batch_get();
  $current_set = &_batch_current_set();
  $set_changed = TRUE;

  if (empty($current_set['start'])) {
    $current_set['start'] = microtime(TRUE);
  }
  $queue = _batch_queue($current_set);
  while (!$current_set['success']) {
    // If this is the first time we iterate this batch set in the current
    // request, we check if it requires an additional file for functions
    // definitions.
    if ($set_changed && isset($current_set['file']) && is_file($current_set['file'])) {
      include_once DRUPAL_ROOT . '/' . $current_set['file'];
    }

    $task_message = '';
    // Assume a single pass operation and set the completion level to 1 by
    // default.
    $finished = 1;

    if ($item = $queue->claimItem()) {
      [$callback, $args] = $item->data;

      // Build the 'context' array and execute the function call.
      $batch_context = [
        'sandbox'  => &$current_set['sandbox'],
        'results'  => &$current_set['results'],
        'finished' => &$finished,
        'message'  => &$task_message,
      ];

      // Tolerate recoverable errors.
      // See https://github.com/drush-ops/drush/issues/1930
      $halt_on_error = \Drush\Drush::config()->get('runtime.php.halt-on-error', TRUE);
      \Drush\Drush::config()->set('runtime.php.halt-on-error', FALSE);
      call_user_func_array($callback, array_merge($args, [&$batch_context]));
      if (!empty($task_message)) {
        Drush::logger()->notice(strip_tags($task_message));
      }
      \Drush\Drush::config()->set('runtime.php.halt-on-error', $halt_on_error);

      if ($finished >= 1) {
        // Make sure this step is not counted twice when computing $current.
        $finished = 0;
        // Remove the processed operation and clear the sandbox.
        $queue->deleteItem($item);
        $current_set['count']--;
        $current_set['sandbox'] = [];
      }
    }

    // When all operations in the current batch set are completed, browse
    // through the remaining sets, marking them 'successfully processed'
    // along the way, until we find a set that contains operations.
    // _batch_next_set() executes form submit handlers stored in 'control'
    // sets (see form_execute_handlers()), which can in turn add new sets to
    // the batch.
    $set_changed = FALSE;
    $old_set = $current_set;
    while (empty($current_set['count']) && ($current_set['success'] = TRUE) && _batch_next_set()) {
      $current_set = &_batch_current_set();
      $current_set['start'] = microtime(TRUE);
      $set_changed = TRUE;
    }

    // At this point, either $current_set contains operations that need to be
    // processed or all sets have been completed.
    $queue = _batch_queue($current_set);

    // If we are in progressive mode, break processing after 60% of memory usage
    // is reached.
    if (drush_memory_limit() > 0 && (memory_get_usage() * 1.6) >= drush_memory_limit()) {
      Drush::logger()->notice(dt("Batch process has consumed in excess of 60% of available memory. Starting new thread"));
      // Record elapsed wall clock time.
      $current_set['elapsed'] = round((microtime(TRUE) - $current_set['start']) * 1000, 2);
      break;
    }
  }

  // Reporting 100% progress will cause the whole batch to be considered
  // processed. If processing was paused right after moving to a new set,
  // we have to use the info from the new (unprocessed) set.
  if ($set_changed && isset($current_set['queue'])) {
    // Processing will continue with a fresh batch set.
    $remaining        = $current_set['count'];
    $total            = $current_set['total'];
    $progress_message = $current_set['init_message'];
    $task_message     = '';
  }
  else {
    // Processing will continue with the current batch set.
    $remaining        = $old_set['count'];
    $total            = $old_set['total'];
    $progress_message = $old_set['progress_message'];
  }

  $current    = $total - $remaining + $finished;
  $percentage = _batch_api_percentage($total, $current);
  return ($percentage == 100);
}

/**
 * End the batch processing:
 * Call the 'finished' callbacks to allow custom handling of results,
 * and resolve page redirection.
 *
 * @return array
 */
function _drush_batch_finished() {
  $results = [];

  $batch = &batch_get();

  // Execute the 'finished' callbacks for each batch set, if defined.
  foreach ($batch['sets'] as $id => $batch_set) {
    if (isset($batch_set['finished'])) {
      // Check if the set requires an additional file for function definitions.
      if (isset($batch_set['file']) && is_file($batch_set['file'])) {
        include_once DRUPAL_ROOT . '/' . $batch_set['file'];
      }
      if (is_callable($batch_set['finished'])) {
        $queue = _batch_queue($batch_set);
        $operations = $queue->getAllItems();
        $elapsed = $batch_set['elapsed'] / 1000;
        $elapsed = \Drupal::service('date.formatter')->formatInterval($elapsed);
        call_user_func_array($batch_set['finished'], [$batch_set['success'], $batch_set['results'], $operations, $elapsed]);
        $results[$id] = $batch_set['results'];
      }
    }
  }

  // Clean up the batch table.
  \Drupal::service('batch.storage')->delete($batch['id']);

  foreach ($batch['sets'] as $batch_set) {
    if ($queue = _batch_queue($batch_set)) {
      $queue->deleteQueue();
    }
  }

  $batch = NULL;
  $results['drush_batch_process_finished'] = TRUE;

  return $results;
}

/**
 * Shutdown function: store the batch data for next request,
 * or clear the table if the batch is finished.
 */
function _drush_batch_shutdown() {
  if ($batch = batch_get()) {
    /** @var \Drupal\Core\Batch\BatchStorage $batch_storage */
    $batch_storage = \Drupal::service('batch.storage');
    $batch_storage->update($batch);
  }
}
