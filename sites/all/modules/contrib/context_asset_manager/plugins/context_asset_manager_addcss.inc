<?php

/**
 * @file
 * The Context reaction plugin to add CSS files.
 *
 * Contextually add CSS files to any page on your site.
 */

// Load the base Add Assets Reaction class.
if (!class_exists('context_asset_manager_base')) {
  module_load_include('inc', 'context_asset_manager', 'plugins/context_asset_manager_base');
}

/**
 * Expose themes as context reactions.
 */
class context_asset_manager_addcss extends context_asset_manager_base {
  public $search_scope;

  /**
   * Constructor Method.
   */
  public function __construct($plugin, $info) {
    parent::__construct($plugin, $info);
    $this->title = t('CSS from Themes');
    $this->search_type = 'css|sass|scss|less';
  }

}
