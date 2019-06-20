<?php
/**
 * @file
 * Functions only needed on the configuration page.
 */


/**
 * Implements hook_form().
 *
 * Builds the configuration form.
 */
function defer_image_form($form, &$form_state) {
  $form['defer_image_element'] = array(
    '#type' => 'textfield',
    '#title' => t('Deferred image element'),
    '#default_value' => variable_get('defer_image_element', 'span'),
    '#description' => t("The HTML element used as the placeholder before the image is loaded and as the wrapper once the image has loaded. This would ideally be an inline element that doesn't have pre-defined styles. It must not be a self-closing element such as &lt;img&gt;. &lt;span&gt; is used by default or if the field is left blank. <br><strong>Don't input angle brackets</strong>."),
  );
  $form['defer_image_class'] = array(
    '#type' => 'textfield',
    '#title' => t('Deferred image element class'),
    '#default_value' => variable_get('defer_image_class', 'defer-image-load'),
    '#description' => t("The class used for the placeholder/wrapper of the defered image. This can be changed if your site already has deferred images in content that use a class other than the default <em>defer-image-load</em>."),
  );
  $form['defer_image_timing'] = array(
    '#type' => 'radios',
    '#title' => t('Deferred image timing'),
    '#options' => array(
      'load' => 'Window Load',
      'ready' => 'Document Ready',
    ),
    '#default_value' => variable_get('defer_image_timing', 'load'),
    '#description' => t("When should deferred images be loaded to the page? <br><strong>Window Load</strong> happens when the page is fully loaded with all resources.<br><strong>Document Ready</strong> happens a bit sooner when the HTML document is loaded and the DOM is ready."),
  );

  return system_settings_form($form);
}
