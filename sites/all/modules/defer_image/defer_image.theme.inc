<?php
/**
 * @file
 * Defer Image theme functions.
 */


/**
 * Returns HTML for a deferred image loader with <noscript> backup.
 *
 * @param $variables
 *   An associative array containing:
 *   - item: An array of image data.
 *   - image_style: An optional image style.
 *   - path: An array containing the link 'path' and link 'options'.
 *
 * @ingroup themeable
 */
function theme_defer_image($variables) {
  $item = $variables['item'];
  $image = array(
    'path' => $item['uri'],
  );
  $image_style = $variables['image_style'];

  $image_uri = ($image_style) ? _defer_image_render_image_style_uri($item, $image_style) : $item['uri'];
  // If an image style is being used, we need to use image_style_url() to make
  // sure we get the 'itok' query param at the end of the URL.
  $image_url = ($image_style) ? image_style_url($image_style, $item['uri']) : file_create_url($image_uri);

  // Ensure that we have the correct image dimensions if an image style is used
  if ($image_info = image_get_info($image_uri)) {
    $item['width'] = $image_info['width'];
    $item['height'] = $image_info['height'];
  }

  // Set properties to the $image array and build string of data attributes
  $properties = array('alt', 'title', 'width', 'height');
  $defer_attributes = 'data-defer-src="' . $image_url . '"';
  foreach ($properties as $property) {
    if (isset($item[$property]) && $item[$property] != NULL && drupal_strlen($item[$property]) > 0) {
      $image[$property] = $item[$property];
      $defer_attributes .= ' data-defer-' . $property . '="' . $image[$property] . '" ';
    }
  }

  if (isset($item['attributes'])) {
    $image['attributes'] = $item['attributes'];
    // Make sure to add any other attriputes as data- attributes. The JS will
    // make these actual attributes on the final loaded image.
    foreach ($image['attributes'] as $key => $value) {
      if (is_array($value)) {
        $value = implode(' ', $value);
      }
      $defer_attributes .= ' data-defer-' . $key . '="' . $value . '" ';      
    }
  }

  // Generate markup to be used with the <noscript> fallback
  if ($image_style) {
    $image['style_name'] = $variables['image_style'];
    $output = theme('image_style', $image);
  }
  else {
    $output = theme('image', $image);
  }

  $defer_element = variable_get('defer_image_element', 'span');
  $defer_class = variable_get('defer_image_class', 'defer-image-load');
  $output = '<' . $defer_element . ' class="' . $defer_class . '" ' . $defer_attributes . '>
      <noscript>' . $output . '</noscript>
    </' . $defer_element . '>';

  // The link path and link options are both optional, but for the options to be
  // processed, the link path must at least be an empty string.
  if (isset($variables['path']['path'])) {
    $path = $variables['path']['path'];
    $options = isset($variables['path']['options']) ? $variables['path']['options'] : array();
    // When displaying an image inside a link, the html option must be TRUE.
    $options['html'] = TRUE;
    $output = l($output, $path, $options);
  }

  return $output;
}
