<div class="topheader">

<div class="container">

	<!-- <div class="pull-left hidden-xs">

    	<span><img src="<?php //print drupal_get_path('theme', 'health');

 ?>/img/email-icon.png"> info@healthtravellatvia. lv</span>

    	<span><img src="<?php //print drupal_get_path('theme', 'health');

 ?>/img/phone-icon.png">  +371 67147905</span>

    </div> -->

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

    	<a href="#" onclick='printThisPage()'><img src="<?php print base_path().drupal_get_path('theme', 'health');

 ?>/img/print-icon.png"></a>

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

      <a class="navbar-brand" href="<?php echo $front_page; ?>"><img src="<?php echo $logo; ?>"></a>

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



<!--Content-->

<div class="about">

<div class="container">

<div class="row">

  <!-- <div class="col-sm-3">

      <div class="left-menu">

            <?php //print render($page['left-sidebar']); ?>

      </div>

    </div> -->

  <div class="col-sm-8">

      <div class="about-content">

          <?php if ($title): ?>

            <h2 class="title" id="page-title">

              <?php print $title; ?>

            </h2>

          <?php endif; ?>



          <?php 

        if ($tabs){ 
          echo '<div class="tabs">'; print render($tabs); echo '</div>';
        }

          print render($page['content']); ?>

          <?php //echo "<pre>"; print_r($page['content']); exit(); ?>

        </div>

    </div>

  <div class="col-sm-4 contact_form_mob_view">

      <div class="form-main">

            <?php print render($page['contact']); ?>          

        </div>

             

        <div class="right-slider">

          <div class="left-menu">

            <?php print render($page['jaunumi-slider']); ?>

          </div>

        </div>

    </div>

</div>

</div>

</div>

<!-- Content-->



<!--icons above footer-->

<!-- <div class="PAKALPOJUMI">

	<div class="container">

    	<h2 class="home-head">PAKALPOJUMI</h2> 

      <?php //print render($page['pakalpojumi']); ?>

    </div>

</div> -->

<!--icons above footer-->



<!-- Footer-->

<div class="footer">

  <div class="container">

      <div class="row">

          <div class="col-xs-9 col-sm-3">

            <h3 class="hidden-xs"><?php echo t('ADDRESS:'); ?></h3>

            <?php print render($page['footer-left']); ?>    

          </div>



          <div class="col-xs-3 col-sm-5 footer-mid">

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
<script type="text/javascript">
function printThisPage(){
  window.print();
}
</script>