<?php



/**

 * @file

 * Default simple view template to all the fields as a row.

 *

 * - $view: The view in use.

 * - $fields: an array of $field objects. Each one contains:

 *   - $field->content: The output of the field.

 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.

 *   - $field->class: The safe class id to use.

 *   - $field->handler: The Views field handler object controlling this field. Do not use

 *     var_export to dump this object, as it can't handle the recursion.

 *   - $field->inline: Whether or not the field should be inline.

 *   - $field->inline_html: either div or span based on the above flag.

 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.

 *   - $field->wrapper_suffix: The closing tag for the wrapper.

 *   - $field->separator: an optional separator that may appear before a field.

 *   - $field->label: The wrap label text to use.

 *   - $field->label_html: The full HTML of the label to use including

 *     configured element type.

 * - $row: The raw result object from the query, with all data it fetched.

 *

 * @ingroup views_templates

 */

?>

<?php 

	$tid = $row->tid;

	$path = drupal_get_path_alias('taxonomy/term/'.$tid); 

	$uri = $row->field_field_ikona[0]['raw']['uri'];

	$blue_uri = $row->field_field_ikona_light[0]['raw']['uri'];

	$url = file_create_url($uri);
	$blue_uri = file_create_url($blue_uri);
	$title = $row->taxonomy_term_data_name;

 ?>



<div class="col-half-offset col-xs-3">

	<div class="home-box">

		<a class="service-icon" href="<?php print url($path); ?>">

    		<img src="<?php echo $url; ?>" class="green" alt="<?php echo $title; ?>" />

    		<img src="<?php echo $blue_uri; ?>" class="blue" style="display: none;" alt="<?php echo $title; ?>" />

        	<p><?php echo $title; ?></p>

        </a>

    </div>

</div>



