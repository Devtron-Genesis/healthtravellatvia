<div class="topheader">

<div class="container">

  <?php print render($page['top-contact']); ?>

    <div class="pull-right">

      <div class="text-inc">

        <!-- <select>

          <option>English</option>

        </select> -->

        <?php print render($page['language']); ?>

      <!-- <a href="" class="large-a">A</a> |

      <a href="" class="medium-a">A</a> |

      <a href="" class="small-a">A</a> -->

      <a href="#" onclick='printThisPage()'><img alt="print-icon" src="<?php print base_path().drupal_get_path('theme', 'health');

 ?>/img/print-icon.png" /></a>

        </div>

    </div>

</div>

</div>

<!-- Top-section-->

<!-- Header -->

<div class="menu">

<nav class="navbar navbar-default">

  <div class="container">

    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

        <span class="sr-only">Toggle navigation</span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

      </button>
      
      <a class="navbar-brand" href="<?php echo $front_page; ?>"><img alt="logo" src="<?php echo $logo; ?>" /></a>

    </div>



    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <div class="visible-xs">

          <?php 

        $primary_menu = menu_tree('menu-primary-menu');

       print theme('links__menu_primary_menu', array('links' => $primary_menu, 'attributes' => array('class' => array('nav','navbar-nav','primary_mob_menu'))));

           ?>

      </div>
      
      <?php 

           print render($main_menu);

       ?>

      

    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->

</nav>

</div>

<!-- Header -->

<!-- Menu-->

<div class="slider">

<div class="new-menu hidden-xs">



<nav class="navbar navbar-default">

  <div class="">

    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">

        <span class="meni-show">Main Menu</span>

      </button>

    </div>



    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">

      <?php

        $primary_menu = menu_tree('menu-primary-menu');

       print theme('links__menu_primary_menu', array('links' => $primary_menu, 'attributes' => array('class' => array('nav','navbar-nav','container','primary-menu')))); ?>

    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->

</nav>

</div>

<!--Menu-->

<!-- Slider-->



<!-- video content with have question form-->

<div class="container print-front">

  <div class="row">

      <div class="col-xs-12 col-sm-3 contact-form-sidebar">
            <?php print render($page['slider']); ?>         
      </div>

      <div class="col-xs-12 col-sm-6 video-front">

        <div class="embed-responsive embed-responsive-16by9">

          <?php global $language; 
            $lang_name = $language->language ;
            if ($lang_name == "lv") { ?>
          <iframe class="embed-responsive-item" width="100%" height="100%" src="https://www.youtube.com/embed/uM4QVRbOT50" frameborder="0" allowfullscreen></iframe> 
           <?php }
            else if ($lang_name == "en") { ?>
          <iframe class="embed-responsive-item" width="100%" height="100%" src="https://www.youtube.com/embed/NdAtMk8BBUU" frameborder="0" allowfullscreen></iframe> 
           <?php }     
           else{ ?>
            <iframe class="embed-responsive-item" width="100%" height="100%" src="https://www.youtube.com/embed/F2F2Ut7AaGo" frameborder="0" allowfullscreen></iframe>
            <?php }
           ?>
        </div>

      </div>

      <div class="col-xs-12 col-sm-3 hidden-xs contact-form-sidebar">

          <div class="form-main">

            <?php print render($page['contact']); ?>          

        </div>

      </div>

  </div>

</div>



</div>



<!-- content-->

<div class="PAKALPOJUMI">

  <div class="container">

      <?php print render($page['pakalpojumi']); ?>

    </div>

</div>



<!-- Slider-lower-->

<div class="low-slider">

  <div class="container">

      <div class="row">

          <div class="col-xs-12 col-sm-9 news-front">

              <?php 

                    $viewName = 'jaunumi';

                    print views_embed_view($viewName);

               ?>

            </div>

            <div class="hidden-xs col-xs-12 col-sm-3">

              <?php print render($page['jaunumi-slider']); ?>

         

            </div>

        </div>

    </div>

</div>

<!-- Slider-lower-->

<!-- content-->

<!-- Saulkrasti-->

<?php 

    //$viewName = 'pilsetas';

    //print render($page['pilsetas']);

    //echo views_embed_view('pilsetas', 'block');

?>

<div class="container">

  <div class="row">

      <div class="col-xs-12 hidden-sm hidden-md hidden-lg cont_form">

          <div class="form-main">

            <?php print render($page['contact']); ?>          

        </div>

      </div>

  </div>

</div>



<!-- logo-->

<div class="container hidden-xs">

  <div class="row">

    <?php print render($page['logos']); ?> 

      <!-- <div class="col-sm-4">

          <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/logofooter.png"></a>

      </div>



      <div class="logo-equal">

          <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/Layer-18.png"></a>

 <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/liaa.png"></a>

      </div>



      <div class="logo-equal">

          <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/eraf1.png"></a>

 <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/liveriga1.png"></a>

      </div>



      <div class="logo-equal">

          <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/download.png"></a>

 <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/lr_arlietu_ministrija.png"></a>

      </div>



      <div class="logo-equal">

          <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/cla.png"></a>

 <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/bsr.png"></a>

      </div>



      <div class="logo-equal">

          <a href=""><img class="img-responsive" src="<?php //base_path().print drupal_get_path('theme', 'health');

 ?>/img/header-logo.png"></a>

      </div> -->

  </div>

</div>



<!-- Footer-->

<div class="footer">

  <div class="container">

      <div class="row">

          <div class="col-xs-6 col-sm-3 footer-add">

            <h3 class="hidden-xs"><?php echo t('ADDRESS:'); ?></h3>

            <?php print render($page['footer-left']); ?>    

          </div>



          <div class="col-xs-6 col-sm-5 footer-mid">

            <h3 class="hidden-xs"><?php echo t('FOLLOW US:'); ?></h3>

            <?php print render($page['footer-middle']); ?>    

          </div>



          <div class="col-xs-12 pull-left col-sm-4 print-footer">

              <h3><?php echo t('NEWSLETTER SIGN UP:'); ?></h3>

              <?php print render($page['footer-right']); ?>

              <h5><?php echo t('Healthtravellatvia ©2017 All Rights Reserved.'); ?></h5>

            </div>

        </div>

    </div>

</div>

<!-- Footer-->
<script type="text/javascript">
function printThisPage(){
  window.print();
}
</script>