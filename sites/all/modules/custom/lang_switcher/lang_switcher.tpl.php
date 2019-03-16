<?php 
  
global $base_url;
global $language ;
$lang_name = $language->language ;
$path = current_path(); 

if (arg(0) ==  "taxonomy" && arg(1) == "term" && is_numeric(arg(2))) {
  
  $tid = arg(2);
  $term = taxonomy_term_load($tid);
   
  $term_en =  i18n_taxonomy_term_get_translation($term, 'en');
  $tid_en = $term_en->tid;


  $term_lv =  i18n_taxonomy_term_get_translation($term, 'lv');
  $tid_lv = $term_lv->tid;  

  $term_ru =  i18n_taxonomy_term_get_translation($term, 'ru');
  $tid_ru = $term_ru->tid;  

   
  $en_url = drupal_get_path_alias('taxonomy/term/' . $tid_en, 'en');
  $lv_url = drupal_get_path_alias('taxonomy/term/' . $tid_lv, 'lv');
  $ru_url = drupal_get_path_alias('taxonomy/term/' . $tid_ru, 'ru');

 

}else{
  $translations = translation_path_get_translations($path);  
  $en_url =  drupal_get_path_alias($translations['en'],'en');
  $lv_url =  drupal_get_path_alias($translations['lv'],'lv');
  $ru_url =  drupal_get_path_alias($translations['ru'],'ru');
}
 
$icon = array();

$icon['en'] =   $base_url.'/'.drupal_get_path('module', 'lang_switcher').'/images/en.png' ;
$icon['lv'] =   $base_url.'/'.drupal_get_path('module', 'lang_switcher').'/images/lv.png' ;
$icon['ru'] =   $base_url.'/'.drupal_get_path('module', 'lang_switcher').'/images/ru.png' ;

?>

 
<img src="<?php echo $icon[$lang_name] ; ?>" alt="<?php echo $lang_name; ?>" width="18px"  height="12px" />
<div class="dropdown">
<button onclick="switch_language()" class="dropbtn">&#9660;</button>
  <div id="langDropdown" class="dropdown-content">
   <a href="<?php echo $base_url."/en/".$en_url;?>"><img src="<?php echo $icon['en']; ?>" alt="en Republic" width="18px"  height="12px" /></a>
   <a href="<?php echo $base_url."/lv/".$lv_url;?>"><img src="<?php echo $icon['lv']; ?>" alt="lv Republic"  width="18px"  height="12px" /></a>
   <a href="<?php echo $base_url."/ru/".$ru_url;?>"><img src="<?php echo $icon['ru']; ?>" alt="ru Republic"  width="18px"  height="12px" /></a>
  </div>
</div>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function switch_language() {
    document.getElementById("langDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

 
