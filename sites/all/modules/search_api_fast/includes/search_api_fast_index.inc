<?php

/**
 * @file
 * Callbacks for drush indexing.
 */

/**
 * Command callback for drush queue-run-concurrent.
 *
 * Queue runner that is compatible with queues declared using both
 * hook_queue_info() and hook_cron_queue_info().
 *
 * @param string $index_name
 *   SAPI index machine-name.
 * @param string $clear
 *   Action to take on index prior to indexing.
 *   Empty, 'clear' of 'reindex'.
 */
function search_api_fast_index_fast($index_name = '', $clear = '') {

  // Let our watchdog know search_api_fast is initiated.
  search_api_fast_active(TRUE);

  if ($index_name && $index = search_api_index_load($index_name)) {

    // Check for other processes that mow the grass for MY feet away! Mofo's...
    // BTW, is $index_name injectable here? No, since we checked if it was a
    // real loadable index.
    if (search_api_fast_already_running($index_name)) {
      drush_print('Some other process already running my commands... Exit.');
      exit;
    }

    // Clear index.
    if ($clear == 'clear') {
      $index->clear();
    }
    elseif ($clear == 'reindex') {
      $index->reindex();
    }

    // Get to-index items.
    $items = search_api_get_items_to_index($index);
    drush_print(count($items) . ' items need to be indexed');
    if ($items) {

      // Check again for already running processes that ME I would like
      // to spawn. Some time has probably passed since loading the indexable
      // items.
      // BTW, we can't get the parent pid of ME, because drush is effectively
      // detaching it. So, this is the most efficient way to do this.
      // I think...
      if (search_api_fast_already_running($index_name)) {
        drush_print('Some other process already running my commands... Exit.');
        exit;
      }

      // Initiate queues.
      // One for each concurrent process.
      $queues = array();
      for ($worker = 0; $worker < SEARCH_API_FAST_INDEX_WORKERS; $worker++) {
        $queues[$worker] = search_api_fast_get_queue('search_api_fast_index_fast_' . $index_name . '_' . $worker);
        // Remove and create queue.
        // Removal is to avoid endless queue-buildup if command is
        // invoked more than once.
        $queues[$worker]->deleteQueue();
        $queues[$worker]->createQueue();
      }

      // Add items to queue.
      $queue_index = 0;
      $item_queues = array();
      foreach ($items as $item) {
        $item_queues[$queue_index][] = $item;
        // Cycle queues round robin.
        if ($queue_index == (count($queues) - 1)) {
          $queue_index = 0;
        }
        else {
          $queue_index++;
        }
      }
      // Create queues.
      foreach ($item_queues as $queue_index => $items) {
        $queues[$queue_index]->createItems($items);
      }

      // Spawn new process for each queue.
      foreach ($item_queues as $queue_index => $items) {
        if (!empty($items)) {
          search_api_fast_fast_index_queue_invoke($index_name, $queue_index);
        }
      }
    }
    else {
      drush_print('Nothing to do');
    }
  }
  else {
    // Print indexes.
    drush_search_api_list();
  }
}

/**
 * Spawn new drush process to start worker for indexing stuff.
 *
 * @param string $index_name
 *   Sapi index.
 * @param int $worker
 *   Queue number.
 */
function search_api_fast_fast_index_queue_invoke($index_name, $worker) {
  // Get drush binary from script runtime parameters,
  // or guess.
  $drush = escapeshellarg(variable_get('drush', 'drush'));
  if (php_sapi_name() == 'cli') {
    global $argv;
    if (strpos($argv[0], 'drush') !== FALSE) {
      $drush = escapeshellcmd($argv[0]);
    }
  }

  $command = 'nohup ' . $drush . ' search-api-index-fast-queue ' . $index_name . ' ' . $worker . ' > /dev/null 2>&1 &';
  drush_print('Invoking command: ' . $command);
  exec($command);
}

/**
 * Process search index queue.
 *
 * Invoked by drush.
 *
 * @param string $index_name
 *   Sapi index.
 * @param int $worker
 *   Queue number.
 *
 * @return bool
 *   TRUE on success, FALSE on failure.
 */
function search_api_fast_index_fast_queue_worker($index_name, $worker) {

  // Let our watchdog know search_api_fast is initiated.
  search_api_fast_active(TRUE);

  if ($worker >= 0 && $worker <= SEARCH_API_FAST_INDEX_WORKERS) {
    // Get queue for this worker.
    $queue = search_api_fast_get_queue('search_api_fast_index_fast_' . $index_name . '_' . $worker);

    // Loop queue.
    // Note that search_api_fast_respawn() might respawn this worker
    // breaking up this loop while the respawned process takes it further.
    while ($queue->numberOfItems()) {

      // Create small batches to index.
      // $items will hold each batch.
      $item_lists = array();
      while (count($item_lists) < SEARCH_API_FAST_MAX_BATCHES_WORKER_RESPAWN && $items = $queue->claimItems(SEARCH_API_FAST_WORKER_BATCH_SIZE)) {
        $item_lists[] = $items;
        $queue->deleteItems(array_keys($items));
      }

      // Get index.
      if ($index = search_api_index_load($index_name)) {
        // Index each batch.
        foreach ($item_lists as $item_list) {
          try {
            // Index the motherfuckers.
            search_api_index_specific_items($index, $item_list);

            // Clear entity cache.
            // If not done, this becomes a huge memory leak.
            // Still, php GC is crap.
            search_api_fast_reset_entity_cache();
          }
          catch (SearchApiException $e) {
            drush_print($e);
            return FALSE;
          }
        }

        // Respawn because php GC works like crap.
        if ($queue->numberOfItems()) {
          search_api_fast_respawn();
        }
      }
    }
  }
  return TRUE;
}

/**
 * Queue workers already spawned ?
 *
 * @param string $index_name
 *   Index name.
 *
 * @return bool
 *   TRUE: yes. FALSE: no queue workers around.
 */
function search_api_fast_already_running($index_name) {
  exec("ps -ef | grep 'search-api-index-fast-queue " . escapeshellarg($index_name) . "\b' | grep -v grep", $proclist);
  if (!empty($proclist)) {
    return TRUE;
  }
  return FALSE;
}

/**
 * Load queue object.
 *
 * This one provides setting, getting, claiming items in multiples.
 * Saves a HUGE amount of queries (minutes).
 *
 * @param string $name
 *   Queue name.
 *
 * @return \SearchApiFastSearchQueue
 *   Queue object.
 */
function search_api_fast_get_queue($name) {
  return new SearchApiFastSearchQueue($name);
}

/**
 * Reset entity cache.
 */
function search_api_fast_reset_entity_cache() {
  $reset_entity_types = array(
    'taxonomy_term',
    'node',
    'field_collection_item',
    'paragraphs_item',
  );
  foreach ($reset_entity_types as $entity_type) {
    $controllers = drupal_static('entity_get_controller', array());
    if (isset($controllers[$entity_type])) {
      entity_get_controller($entity_type)->resetCache();
    }
  }

  gc_collect_cycles();
}

/**
 * Respawn ME if this is a drush process.
 *
 * Used to tame memory usage vs garbage collection (lack thereof).
 */
function search_api_fast_respawn() {
  if (php_sapi_name() == 'cli') {
    global $argv;

    if (strpos($argv[0], 'drush') !== FALSE) {
      $cmd = escapeshellcmd($argv[0]);
      unset($argv[0]);
      $params = array();
      foreach ($argv as $arg) {
        $params[] = escapeshellarg($arg);
      }
      $cmd .= ' ' . implode(' ', $params);

      exec('nohup ' . $cmd . ' > /dev/null 2>&1 &');
      drupal_exit();
    }
  }
}
