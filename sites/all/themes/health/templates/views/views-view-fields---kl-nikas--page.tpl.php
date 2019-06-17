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
<?php //echo "<pre>"; print_r($row); exit();
		//echo $view->result[$id]->nid; exit();
		$uri = $row->field_field_bilde[0]['raw']['uri'];
		$url = image_style_url('clinics_thumbnail', $uri);
		$nid = $row->nid;
		$alias = drupal_get_path_alias('node/'.$nid.'');
		$node_language = $row->node_language;
		$www = $row->field_field_www[0]['raw']['value'];
		if(!strpos($www, 'http')){
			$www = "http://".trim($www);
		}
 ?>
<div class="col-sm-6 all-clinics">
	<h3><a href="<?php print base_path().$node_language.'/'.$alias; ?>"><?php echo $row->node_title; ?></a></h3>
	<a href="<?php print base_path().$node_language.'/'.$alias; ?>"><img style="height: 200px; width: 100%;" class="img-responsive" src="<?php echo $url; ?>"></a>

	<div class="clinics_border">
	
	<p class="limit-body"><?php 
			$body_result = preg_replace('#<div class="clinic_img">(.*?)</div>#is', '', $row->field_body[0]['rendered']['#markup']);
			//$body_result = substr($body_result,0,150).'...';
			echo strip_tags($body_result);
		?></p>
	<div class="row">

		<div class="col-xs-8 col-sm-7 limit-address">
			<?php print $view->render_field('field_kl_nikas_adrese', $view->row_index); ?>
		</div>
		<div class="col-xs-2 col-sm-2 col-sm-offset-1 clinic_wespeak">
    	<?php echo t(''); ?></div>
		<div class="col-xs-2 col-sm-2 clinic_wespeak">
			<?php      
		         foreach ($row->field_field_m_s_run_jam as $key => $value) {
		    ?>
		    <img src="<?php print base_path().drupal_get_path('theme', 'health'); ?>/img/flags/<?php echo $value['raw']['value']; ?>.png" class="img-responsive clinics-flags">
		    <?php } ?>
		</div>

	</div>
	
	<a style="float: right;" href="<?php print base_path().$node_language.'/'.$alias; ?>"><?php echo t('Read More'); ?></a>
	<a style="float: left;" target="_blank" href="<?php echo $www; ?>"><?php echo $www; ?></a>	
	</div>
</div>
	