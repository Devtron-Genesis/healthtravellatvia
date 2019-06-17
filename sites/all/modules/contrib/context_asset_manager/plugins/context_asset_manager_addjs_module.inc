<?php

/**
 * @file
 * The Context reaction plugin to add Module CSS files.
 *
 * Contextually add Module CSS files to any page on your site.
 */

/**
 * Expose themes as context reactions.
 */
class context_asset_manager_addjs_module extends context_asset_manager_addjs {

  /**
   * Constructor Method.
   */
  public function __construct($plugin, $info) {
    parent::__construct($plugin, $info);
    $this->search_scope = 'modules';
    $this->title = t('JS from Modules');
  }

}
