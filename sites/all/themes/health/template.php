<?php

function health_preprocess_html(&$vars) {

	$X_UA_Compatible = array(

	  '#tag' => 'meta', 

	  '#attributes' => array(

	    'name' => 'X-UA-Compatible', 

	    'content' => 'IE=edge',

	  ),

	);

	$viewport = array(

	  '#tag' => 'meta', 

	  '#attributes' => array(

	    'name' => 'viewport', 

	    'content' => 'width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=1',

	  ),

	);

	$apple_mobile_web_app_capable = array(

	  '#tag' => 'meta', 

	  '#attributes' => array(

	    'name' => 'apple-mobile-web-app-capable', 

	    'content' => 'yes',

	  ),

	);

	drupal_add_html_head($X_UA_Compatible, 'X-UA-Compatible');

	drupal_add_html_head($viewport, 'viewport');

	drupal_add_html_head($apple_mobile_web_app_capable, 'apple-mobile-web-app-capable');
  drupal_add_html_head($google_tag_manager, 'apple-mobile');



}

function health_form_alter(&$form, &$form_state, $form_id){

	if($form_id == 'search_block_form'){

		$form['search_block_form']['#prefix'] = '<div class="search hidden-xs">';

		$form['search_block_form']['#suffix'] = '<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i></button></div>';

    	$form['search_block_form']['#attributes']['placeholder'] = t('SEARCH');

    	$form['search_block_form']['#attributes']['class'] = array('form-control input-sm');

    	//$form['actions']['submit']['#access'] = false;

    	//$form['actions']['submit']['#attributes']['class'] = array('btn btn-success btn-sm');

    	$form['actions']['submit']['#value'] = '';

	}

	if($form_id == 'simplenews_block_form_749'){

		

		$form['mail']['#title'] = '';

		$form['mail']['#attributes'] = array('class'=>array('form-control'), 'placeholder'=>t('YOUR EMAIL'));

		$form['mail']['#prefix'] = '<div class="col-sm-8 footer-newsl"><div class="input-group">';



		$form['submit']['#value'] = t('Submit');

		$form['submit']['#attributes'] = array('class'=>array('button btn btn-info'));

		$form['submit']['#prefix'] = '<span class="input-group-btn">';

		$form['submit']['#suffix'] = '</span></div></div>';

	}


		if($form_id == 'webform_client_form_164' || $form_id == 'webform_client_form_139' || $form_id == 'webform_client_form_165'){



			$form['#node']->title = '';

			$form['#attributes'] = array('class'=>array('form-horizontal'));

			

			$form['submitted']['vards_uzvards']['#title'] = '';

      //$form['submitted']['vards_uzvards']['#attributes']['placeholder'] = t('YOUR NAME');

			$form['submitted']['vards_uzvards']['#prefix'] = '<h3>'.t('HAVE A QUESTION?').'</h3><div class="form-group"><label class="col-md-12 control-label"></label><div class="col-md-12">';

			$form['submitted']['vards_uzvards']['#suffix'] = '</div></div>';

			$form['submitted']['vards_uzvards']['#attributes'] = array('class'=>array('form-control') , 'placeholder'=>t('YOUR NAME'));

      

			$form['submitted']['jusu_e_pasts']['#title'] = '';

			$form['submitted']['jusu_e_pasts']['#prefix'] = '<div class="form-group"><label class="col-md-12 control-label"></label><div class="col-md-12">';

			$form['submitted']['jusu_e_pasts']['#suffix'] = '</div></div>';

			$form['submitted']['jusu_e_pasts']['#attributes'] = array('class'=>array('form-control'), 'placeholder'=>t('YOUR EMAIL'));

      global $language ;
      $option = array();
      $lang_name = $language->language ;

      $term_tree_data = array();
      $term_tree = array();

      foreach ($form['submitted']['medicinas_pakalpojumi']['#options'] as $key => $value) {

        $term = taxonomy_term_load($key);
        if(empty($term_tree_data)){
          $term_tree_data = taxonomy_get_tree($term->vid,0,1);
          foreach($term_tree_data as $tree_data){
            $term_tree[] = $tree_data->tid;
          }
        }

        if ($lang_name == $term->language && in_array($term->tid, $term_tree)) {

            $option[$key] = $term->name;
        }

      }
      asort($option);

      $form['submitted']['medicinas_pakalpojumi']['#options'] = $option;

      $form['submitted']['medicinas_pakalpojumi']['#title'] = '';

      $form['submitted']['medicinas_pakalpojumi']['#attributes'] = array('class'=>array('form-control'));

      $form['submitted']['medicinas_pakalpojumi']['#prefix'] = '<div class="form-group"><label class="col-md-12 control-label"></label><div class="col-md-12">';

      $form['submitted']['medicinas_pakalpojumi']['#suffix'] = '</div></div>';

      $form['submitted']['medicinas_pakalpojumi']['#empty_option'] = t('CHOOSE MEDICAL SERVICE');

      //echo "<pre>"; print_r($form['submitted']['medicinas_pakalpojumi']); exit();


			$form['submitted']['komentars_vai_jautajums']['#title'] = '';

			$form['submitted']['komentars_vai_jautajums']['#attributes'] = array('class'=>array('form-control disable_resize'), 'placeholder'=>t('YOUR MESSAGE'));

			$form['submitted']['komentars_vai_jautajums']['#prefix'] = '<div class="form-group"><label class="col-md-12 control-label"></label><div class="col-md-12">';

			$form['submitted']['komentars_vai_jautajums']['#suffix'] = '</div></div>';


			$form['actions']['submit']['#value'] = t('SEND MESSAGE');

			$form['actions']['submit']['#attributes'] = array('class'=>array('btn btn-info btn-have-que'));

			$form['actions']['submit']['#prefix'] = '<div class="form-group have-form-btn"><div class="col-md-12 btn-have">';

			$form['actions']['submit']['#suffix'] = '</div></div>';

		}



}


function health_preprocess_page(&$vars) {

	if(isset($vars['page']['content']['system_main']['no_content'])) {

    	unset($vars['page']['content']['system_main']['no_content']);

  	}

  	$main_menu_tree = menu_tree('main-menu');

  	$vars['main_menu'] = theme('main_header_links',array('links' => $main_menu_tree));

   

}

function health_theme() {

	return array(

        'main_header_links' => array(

            'links' => NULL,

        ),

	 );

}

function health_main_header_links($links){

  $menu_links = $links['links'];

  $attributes = array();

  $heading = '';

  global $language_url;

  $output = '';

  $class2 = '';

  $icon = array('icon-desktop', 'icon-heart', 'icon-home', 'icon-briefcase', 'icon-star', 'icon-cog', 'icon-plus-sign-alt', 'icon-smile', 'icon-flag-checkered', 'icon-flag-checkered');

  //echo "<pre>"; print_r($links); exit;

  if (count($menu_links) > 0) {

    $output = '';

    // Treat the heading first if it is present to prepend it to the

    // list of links.

    if (!empty($heading)) {

      if (is_string($heading)) {

      // Prepare the array that will be used when the passed heading

      // is a string.

        $heading = array(

          'text' => $heading,

          // Set the default level of the heading.

          'level' => 'h2',

        );

      }

      $output .= '<' . $heading['level'];

      if (!empty($heading['class'])) {

        //$output .= drupal_attributes(array('class' => $heading['class']));

      }

      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';

    }

    $output .= '<ul class="nav navbar-nav navbar-right search-menu">';

    $num_links = 0;

    foreach ($menu_links as $key => $link) {

      if(is_numeric($key)){

        $num_links++;

      }

    }

    $i = 1;

    foreach ($menu_links as $key => $link) {

      if(!is_numeric($key)){

          continue;

      }

      $class = array($key);

      $class[] = 'top_level';

    // Add first, last and active classes to the list of links to help out themers.

      if ($i == 1) {

        $class[] = 'first';

      }

      if ($i == $num_links) {

        $class[] = 'last';

      }

      if (isset($link['#href']) && ($link['#href'] == $_GET['q'] || (($link['#href'] == '<front>' || empty($link['#href'])) && drupal_is_front_page()))

             && (empty($link['language']) || $link['language']->language == $language_url->language)) {

        $class[] = 'active';

      }

      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['#href'])) {

        if (strpos($link['#href'], 'nolink')) {

          $output .= '<a class="nolink">' . $link['#title'] . '</a>';

        } else {

          $menutext = "<i class='".$icon[$i-1]." left_icon_list'></i> ".$link['#title']." <i class='icon-chevron-right pull-right right_arrow_list'></i>";

          $output .= l($menutext, drupal_get_path_alias($link["#href"]), array('html' => TRUE));

        }

        if($link['#below']){

          $class1 = '';

          if($i == $num_links-1){

            $class1 = 'news';

          }else if($i == $num_links){

            $class1 = 'about';

          }

          $output .= load_second_level_menu($link['#below'],$class1);  

        }        

      } elseif (!empty($link['#title'])) {

      // Some links are actually not links, but we wrap these in <span> for adding title and class attributes.

      if (empty($link['html'])) {

        $link['#title'] = check_plain($link['#title']);

      }

      $span_attributes = '';

      if (isset($link['attributes'])) {

        //$span_attributes = drupal_attributes($link['attributes']);

      }

    }

      $i++;

      $output .= "</li>\n";

    }

     $search_box1 = drupal_get_form('search_block_form');

     $search_box = drupal_render($search_box1);

     //echo "<pre>"; print_r(drupal_get_form('search_custom_module_form')); exit;

    $output .= '<li class="search-box-menu">'.$search_box.'</li>';

    $output .= '</ul>';

  }

  return $output;

}

function load_second_level_menu($sub_link,$extra_class = '') {

    $output = '';

    $num_links = 0;

    foreach ($sub_link as $key => $link) {

      if(is_numeric($key)){

        $num_links++;

      }

    }

    $class[] = "submenu";

    if(!empty($extra_class)){

      $class[] = $extra_class;

    }

    $output .= '<ul '. drupal_attributes(array('class' => $class)) .'>';

    $k = 1;

    foreach ($sub_link as $key => $link) {

        if(!is_numeric($key)){

          continue;

        }

        if ($k == $num_links) {

            $class[] = 'last';

        }

        //echo "<pre>"; print_r($link); exit;

        $output .= '<li>';                        

            $output .= l($link['#title'], $link['#href']);

            if($link['#below']){

              $output .= load_second_level_menu($link['#below']);

            }

        $output .='</li>';

        $k++;

    }

    $output .= '</ul>';

    return $output;

}

 /**
    * Implements hook_links__system_main_menu().
    *
    * @param array $vars
    * @return string
    *  Themed HTML for bootstrap 3 ready main menu.
    */
    function health_links__menu_primary_menu($vars) {
    // Get the active trail
    $menu_active_trail = menu_get_active_trail();
    // Initialise our custom trail.
    $active_trail = array();

    // Get current path
    $dest = drupal_get_destination();
    if (is_string($dest['destination'])) {
      $paths = explode('/', $dest['destination']);
      // Loop through and add all active paths
      foreach ($paths as $path) {
        // Read previous element added to active trail (using array values
        // preserves original array).
        $safe = array_values($active_trail);
        $previous = array_pop($safe);
        if ($previous) {
          $active_trail[] = $previous . '/' . $path;
        }
        // Or this is the first one
        else {
          $active_trail[] = $path;
        }
      }
    }

    // UL classes
    $class = implode($vars['attributes']['class'], ' ');
    $html = '<ul class="' . $class . '"';
    // Check if there is an ID set (not if it's a dropdown sub-menu).
    if (isset($vars['attributes']['id'])) {
      $html .= ' id="' . $vars['attributes']['id'] . '"';
    }
    $html .= '>';
    // Iterate links to build menu.
    foreach ($vars['links'] as $key => $link) {

      // Check this is a link not a property.
      if (is_numeric($key)) {
        $sub_menu = '';
        $li_class = array();
        $a_class = array();

        // Check if link is in active trail and add class.
        if (in_array($link['#original_link']['link_path'], $active_trail)) {
          $li_class[] = 'active-trail';
        }
        if ($link['#original_link']['link_path'] == end($active_trail)) {
          $li_class[] = 'active';
        }
        // Check if last element in list and see if LI contains actual link
        $link['#attributes']['class'][] = strtolower(str_replace(array('& ', ' '), array('', '-'), $link['#title']));
        $link_title = $link['#title'];
        // Open subscribe in a new window.
        if ($link_title == 'Subscribe') {
          $link['#localized_options']['attributes']['target'] = '_blank';
        }
        if (isset($link['#localized_options']['attributes'])) {
          $link['#attributes'] = array_merge($link['#localized_options']['attributes'], $link['#attributes']);
        }

        // Check if we have a submenu.
        if (!empty($link['#below'])) {
          // Check if lvl 1, if higher do other stuff
          if ($link['#original_link']['depth'] < 2) {
            $li_class[] = 'dropdown';
            $link_title .= '<b class="caret"></b>';
            $link['#attributes']['class'][] = 'dropdown-toggle';
            $link['#attributes']['data-toggle'] = 'dropdown';
          } else {
            $li_class[] = 'dropdown-submenu';
            $link_title .= '<b class="caret"></b>';
          }
          // Theme submenu
          $sub_menu = theme('links__menu_primary_menu', array('links' => $link['#below'], 'attributes' => array('class' => array('dropdown-menu'))));
        }
        // Build classes string
        $classes = '';
        if (!empty($li_class)) {
          $classes = ' class="' . implode($li_class, ' ') . '"';
        }
        $html .= '<li' . $classes . '>' . l($link_title, $link['#href'], array('html' => 'true', 'attributes' => $link['#attributes'])) . $sub_menu . '</li>';
      }
    }
    $html .= '</ul>';
    return $html;
    }
function hook_html_head_alter(&$vars) {
  
      $vars['header_tag'] = "hellow WorLd"; 
  }
