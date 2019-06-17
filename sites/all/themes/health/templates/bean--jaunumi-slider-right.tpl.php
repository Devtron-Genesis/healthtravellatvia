<?php 
      //echo "<pre>"; print_r($bean); exit();
      //$bean->field_slider_images['und']
 ?>
   <div id="low-slider" class="carousel slide mid-slider" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <?php 
                      foreach ($bean->field_slider_images['und'] as $key => $value) {               
                 ?>
                <li data-target="#low-slider" data-slide-to="<?php echo $key; ?>" class="<?php if($key==0) {echo 'active' ;} ?>"></li>
                <?php } ?>
              </ol>
            
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <?php 
                      foreach ($bean->field_slider_images['und'] as $key => $value) { 
                        $uri = $value['uri'];
                        $url = file_create_url($uri);          
                 ?>
                    <div class="item <?php if($key==0) {echo 'active' ;} ?>">
                        <img src="<?php echo $url; ?>" alt="..." class="img-responsive">
                    </div>
                 <?php } ?>
              </div>         
            </div>