<?php

/**
 * @file
 * The Context reaction plugin to add asset files.
 *
 * Contextually add asset files to any page on your site.
 */

/**
 * Expose themes as context reactions.
 */
class context_asset_manager_base extends context_reaction {

  public $search_scope;

  /**
   * Constructor method.
   */
  public function __construct($plugin, $info) {
    parent::__construct($plugin, $info);

    // Defaults are for js - but should never be picked up.
    $this->title = t('JS from Themes');
    $this->search_type = 'js';
  }

  /**
   * Editor form.
   */
  public function editor_form($context) {
    $form = $this->options_form($context);
    return $form;
  }

  /**
   * Submit handler for editor form.
   */
  public function editor_form_submit($context, $values) {
    return $values;
  }

  /**
   * Asset manager configuration Form.
   *
   * Form to pick/choose js/css from context.
   */
  public function options_form($context) {
    $order = range(-100, 100);
    $values = $this->fetch_from_context($context);

    $options = $this->_context_asset_manager_search();
    $options = !$options ? array() : $options;
    $options_array = array();

    foreach ($options as $key => $value) {
      $path = $key;
      $key = explode(' -- ', $value);
      $value = $key[1];
      $key = trim($key[0]);

      if (strpos($path, 'sites/') !== FALSE) {
        // We are keeping jquery_update module out for safety.
        if (strpos($path, 'jquery_update') == FALSE) {
          $options_array['contrib'][$key][$path] = $value;
        }
      }
      else {
        $options_array['core'][$key][$path] = $value;
      }
    }

    $form['#tree'] = TRUE;

    foreach ($options_array as $type => $options_subarray) {

      $form[$type] = array(
        '#markup' => '<h1>' . (($type == 'core') ? 'Drupal Core Assets' : 'Contributed Assets') . '</h1>',
      );

      foreach ($options_subarray as $key => $items) {
        $form[$key] = array(
          '#type' => 'item',
          '#title' => $key,
        );
        $counter = 1;
        foreach ($items as $path => $file_name) {
          $form[$key]['wrapper_' . $counter] = array(
            '#markup' => '<div class="context_item_set">',
          );
          $form[$key][$path] = array(
            '#title' => $file_name,
            '#type' => 'checkbox',
            '#return_value' => $path,
            '#default_value' => isset($values[$key][$path]) ? $values[$key][$path] : '',
            '#attributes' => array('class' => array('div_wide')),
          );
          $form[$key][$path . '_weight'] = array(
            '#title' => 'Weight : ',
            '#type' => 'select',
            '#options' => $order,
            '#default_value' => isset($values[$key][$path . '_weight']) ? $values[$key][$path . '_weight'] : '',
          );
          $ext = explode('.', $path);
          $ext = drupal_strtolower($ext[count($ext) - 1]);
          if ($ext == 'js') {
            $form[$key][$path . '_group'] = array(
              '#title' => "Group",
              '#type' => 'select',
              '#options' => [
                'JS_LIBRARY' => 'Library',
                'JS_DEFAULT' => 'Default',
                'JS_THEME' => 'Theme',
              ],
              '#default_value' => isset($values[$key][$path . '_group']) ? $values[$key][$path . '_group'] : '',
            );
            $form[$key][$path . '_scope'] = array(
              '#title' => "Scope",
              '#type' => 'select',
              '#options' => [
                'header' => 'Header',
                'footer' => 'Footer',
              ],
              '#default_value' => isset($values[$key][$path . '_scope']) ? $values[$key][$path . '_scope'] : '',
            );
            $form[$key][$path . '_defer'] = array(
              '#title' => "Activete Defer load",
              '#type' => 'checkbox',
              '#default_value' => isset($values[$key][$path . '_defer']) ? $values[$key][$path . '_defer'] : '',
            );
            $form[$key][$path . '_async'] = array(
              '#title' => "Activate Async load ",
              '#type' => 'checkbox',
              '#default_value' => isset($values[$key][$path . '_async']) ? $values[$key][$path . '_async'] : '',
            );
            $form[$key][$path . '_preload'] = array(
              '#title' => "Attach Preload Tag",
              '#type' => 'checkbox',
              '#default_value' => isset($values[$key][$path . '_preload']) ? $values[$key][$path . '_preload'] : '',
            );
          }
          elseif ($ext == 'css') {
            $form[$key][$path . '_group'] = array(
              '#title' => "Group",
              '#type' => 'select',
              '#options' => [
                'CSS_SYSTEM' => 'System',
                'CSS_DEFAULT' => 'Default',
                'CSS_THEME' => 'Theme',
              ],
              '#default_value' => isset($values[$key][$path . '_group']) ? $values[$key][$path . '_group'] : '',
            );
            $form[$key][$path . '_critical'] = array(
              '#title' => "Critical",
              '#type' => 'checkbox',
              '#desription' => 'Embded compressed css content in DOM',
              '#default_value' => isset($values[$key][$path . '_critical']) ? $values[$key][$path . '_critical'] : '',
            );
            $form[$key][$path . '_preload'] = array(
              '#title' => "Attach Preload Tag",
              '#type' => 'checkbox',
              '#desription' => 'Attach Preload Tag',
              '#default_value' => isset($values[$key][$path . '_preload']) ? $values[$key][$path . '_preload'] : '',
            );
          }
          $form[$key]['endwrapper_' . $counter] = array(
            '#markup' => '<div style="clear:both"></div></div>',
          );
          $counter++;
        }
      }
    }

    if (count($form) < 2) {
      $link_options['query'] = drupal_get_destination();

      $form['help'] = array(
        '#type' => 'item',
        '#title' => t('No Assets Found'),
      );
    }
    return $form;
  }

  /**
   * Filters deselected files from the listing.
   *
   * Reduces unnecessary conflicts when exporting to Features.
   */
  public function options_form_submit($values) {
    foreach (array_keys($values) as $key) {
      $values[$key] = array_filter($values[$key]);
    }
    return $values;
  }

  /**
   * Implementation of the built-in context plugin class execution.
   */
  public function execute() {
    global $conf;
    $contexts = context_active_contexts();
    $classes = array();
    foreach ($contexts as $key => $value) {
      if (!empty($value->reactions[$this->plugin])) {
        foreach ($value->reactions[$this->plugin] as $path_array) {
          if (is_array($path_array)) {
            foreach ($path_array as $path_key => $path) {
              if ($path) {
                $ext = explode('.', $path);
                $ext = drupal_strtolower($ext[count($ext) - 1]);

                switch ($ext) {
                  case 'js':
                    if (isset($path_array[$path_key . "_preload"]) && $path_array[$path_key . "_preload"] == 1) {
                      drupal_add_html_head_link(array(
                        'rel' => 'preload',
                        'href' => file_create_url($path),
                        'as' => 'script',
                      ));
                    }
                    if (isset($path_array[$path_key . "_defer"]) && $path_array[$path_key . "_defer"] == 1) {
                      drupal_add_js($path, array(
                        'group' => constant($path_array[$path_key . "_group"]),
                        'weight' => $path_array[$path_key . "_weight"],
                        'scope' => $path_array[$path_key . "_scope"],
                        'defer' => TRUE,
                      ));
                    }
                    else {
                      drupal_add_js($path, array(
                        'group' => constant($path_array[$path_key . "_group"]),
                        'scope' => $path_array[$path_key . "_scope"],
                        'weight' => $path_array[$path_key . "_weight"],
                      ));
                    }
                    if (isset($path_array[$path_key . "_async"]) && $path_array[$path_key . "_async"] == 1) {
                      $conf['context_asset_manager']['context_asset_manager_async_js_list'][] = $path;
                    }

                    $conf['context_asset_manager']['context_asset_manager_js_list'][] = $path;
                    break;

                  case 'css':
                  case 'less':
                  case 'sass':
                  case 'scss':
                    if (isset($path_array[$path_key . "_preload"]) && $path_array[$path_key . "_preload"] == 1) {
                      drupal_add_html_head_link(array(
                        'rel' => 'preload',
                        'href' => file_create_url($path),
                        'as' => 'style',
                      ));
                    }
                    if (isset($path_array[$path_key . "_critical"]) && $path_array[$path_key . "_critical"] == 1) {
                      $buffer = file_get_contents($path);
                      // Remove comments.
                      $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
                      // Remove space after colons.
                      $buffer = str_replace(': ', ':', $buffer);
                      // Remove whitespace.
                      $buffer = str_replace(array(
                        "\r\n",
                        "\r",
                        "\n",
                        "\t",
                        '  ',
                        '    ',
                        '    ',
                      ),
                      '', $buffer);
                      drupal_add_css($buffer, array(
                        'type' => 'inline',
                        'group' => constant($path_array[$path_key . "_group"]),
                        'weight' => $path_array[$path_key . "_weight"],
                      ));
                    }
                    else {
                      drupal_add_css($path, array(
                        'group' => constant($path_array[$path_key . "_group"]),
                        'weight' => $path_array[$path_key . "_weight"],
                      ));
                    }
                    $conf['context_asset_manager']['context_asset_manager_css_list'][] = $path;
                    break;
                }
              }
            }
          }
        }
      }
    }
  }

  /**
   * Scan active themes for js files.
   *
   * @return array
   *   An array indexed by file paths
   *   Containing strings describing each path
   *   "Theme Key - File Name"
   */
  public function _context_asset_manager_search() {
    $found_files = _context_asset_manager_scandir($this->search_type, $this->search_scope);
    return $found_files;
  }

}
