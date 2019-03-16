<div class="clinic_slider">
  <?php print render($content['field_bilde']); ?>
</div>
<?php 

//echo "<pre>"; print_r($node); exit();

print render($content['body']); ?>

<div class="row">

  <div class="our_clinics_services">
    <div class="new_clinics_services">
      <h2>CLINIC'S SERVICES</h2>

      <?php
        $node = node_load($nid);

        $items = field_get_items('node', $node, 'field_pakalpojumi', $node->language);
        // print_r($items);
        foreach ($items as $key => $value) {
           $path_link = drupal_get_path_alias('taxonomy/term/' . $value['taxonomy_term']->tid);
           $term_name = ($value['taxonomy_term']->name);
           $language = $node->language;
           
        ?>
        <?php echo "<li>"; ?>
        <a href="<?php echo $path_link; ?>"><?php print_r($value['taxonomy_term']->name); ?></a>
        <?php echo "</li>"; ?>
      <?php } ?>
    </div>
  </div>

  <div class="col-xs-8 col-sm-6">

    <?php print render($content['field_kl_nikas_adrese']); ?>

    <?php  //echo $node->field_www_title['und'][0]['value']; exit();
    if(!empty($node->field_www_title['und'][0]['value'])) { ?>
      <a href="http://<?php echo $node->field_www['und'][0]['value'];  ?>" target="_blank"><?php echo $node->field_www_title['und'][0]['value']; ?></a>
   <?php }
    else{ ?>
    <a href="http://<?php echo $node->field_www['und'][0]['value']; ?>" target="_blank"><?php echo 'http://'.$node->field_www['und'][0]['value']; ?></a>
    <?php } ?>
  </div>

  <div class="col-xs-2 col-sm-2 col-sm-offset-2 clinic_wespeak">

    <?php echo t('We speak:'); ?></div>

  <div class="col-xs-2 col-sm-2 clinic_wespeak">

    <?php //print render($content['field_m_s_run_jam']);

          //echo "<pre>"; print_r($node->field_m_s_run_jam['und']);

          foreach ($node->field_m_s_run_jam['und'] as $key => $value) {

    ?>

    <img src="<?php print base_path().drupal_get_path('theme', 'health'); ?>/img/flags/<?php echo $value['value']; ?>.png" class="img-responsive">

    <?php } ?>

  </div>



</div>



