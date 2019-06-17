<?php

/**
 * @file
 * The Context reaction plugin to add Less files.
 *
 * Contextually add Less files to any page on your site.
 * Requires drupal.org/project/less.
 */

// Load the base Add Page Resource Reaction class.
if (!class_exists('context_asset_manager_base')) {
  module_load_include('inc', 'context_asset_manager', 'plugins/context_asset_manager_base');
}

/**
 * Expose themes as context reactions.
 */
class context_asset_manager_addless extends context_asset_manager_base {
  public $search_scope;

  /**
   * Constructor Method.
   */
  public function __construct($plugin, $info) {
    parent::__construct($plugin, $info);
    $this->title = t('Less from Themes');
    $this->search_type = 'less';
  }

}
