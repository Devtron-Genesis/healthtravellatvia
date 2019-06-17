<?php

/**
 * @file
 * Drush integration file.
 *
 * Drush commands:
 *  - search-api-index-fast [index] [clear]
 *    Index with search api by using a lot of workers.
 *  - search-api-index-fast-queue [index] [worker]
 *    Worker process.
 */

/**
 * Implements hook_drush_command().
 */
function search_api_fast_drush_command() {

  // Include callbacks.
  include_once 'includes/search_api_fast_index.inc';

  $items = array();

  // Init fast indexing.
  $items['search-api-index-fast'] = array(
    'aliases' => array('sapi-fast'),
    'description' => 'Index everything with use of multiple workers',
    'bootstrap' => 'DRUSH_BOOTSTRAP_DRUPAL_FULL',
    'callback' => 'search_api_fast_index_fast',
    'arguments' => array(
      'index' => 'index machine name to run on.',
      'clear' => 'provide "clear" to clear the index first or "reindex" to reindex',
    ),
    'examples' => array(
      'drush search-api-index-fast [index] clear' => dt('Index [index], and clear it first (no reindex)'),
      'drush search-api-index-fast [index] reindex' => dt('Index [index], and mark for reindex first'),
      'drush search-api-index-fast [index]' => dt('Index without clearing, just whats left un-indexed.'),
    ),
  );

  // Worker drush command.
  $items['search-api-index-fast-queue'] = array(
    'aliases' => array('sapi-ifq'),
    'description' => 'Index everything with use of multiple workers: queue worker (dont manually use this)',
    'bootstrap' => 'DRUSH_BOOTSTRAP_DRUPAL_FULL',
    'callback' => 'search_api_fast_index_fast_queue_worker',
    'arguments' => array(
      'index' => 'Index machine name',
      'worker' => 'The worker id, 0 to ' . SEARCH_API_FAST_INDEX_WORKERS,
    ),
  );

  return $items;
}
