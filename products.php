<?php
/**
 * Template Name: Products page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */

?>
<?php get_header(); ?>


 <div id="products" class="row list-group">

  <?php query_posts( 'post_type=products');
  $nr_posts= $wp_query->found_posts;
  $count=1;
  $mod4=$nr_posts % 4;
  $mod3=$nr_posts % 3;
  $bool4=boolval($mod4===0);
  $bool3=boolval($mod3===0);
   ?>

  <?php while ( have_posts() ) : the_post();
      ?>

      <div class="item col-sm-<?php if ($bool4){ echo "3";}else{ echo "4";} ?> col-md-<?php if ($bool4){ echo "3";}else{ echo "4";} ?>">
          <div class="thumbnail">

              <div class="caption">
                  <h4 class="group inner list-group-item-heading">
                      <?php echo get_the_title( ) ;?></h4>
                      <div class="img-wrapper product">
                  <img class="group list-group-image img-rounded img-responsive" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( ), 'medium' )[0]; ?>" alt="" />
                </div>
                  <p class="group inner list-group-item-text bottom1 top1 product description">
                      <?php echo get_the_excerpt();?></p>
                  <div class="row">
                      <div class="col-xs-12 col-md-6">
                          <p class="lead">
                            <i class="fa fa-euro fa"></i><?php  echo get_post_meta($post->ID, 'price', true); ?></p>
                      </div>
                      <div class="col-xs-12 col-md-6">
                          <a class="btn btn-success" href="#">Add to cart</a>
                      </div>
                  </div>
              </div>

          </div>
      </div>


      <?php


      $modcount3=$count % 3;
      $modcount4=$count % 4;


      if ($bool4 && $modcount4===0){
        echo  '</div><div id="products_'.$num.'" class="row list-group">';
      }elseif(!$bool4 && $modcount3===0){
        echo  '</div><div id="products_'.$num.'" class="row list-group">';
      }
      $count++;
      endwhile; // end of the loop.
    ?>
   </div>
</main>






</div>




<?php get_footer(); ?>
