<?php
/**
 * Template Name: Products page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>
 <main class="container" role="main">
 <div class="row">

  <?php query_posts( 'post_type=products'); ?>
  <?php while ( have_posts() ) : the_post();

      $image = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'single-post-thumbnail' );
      $price = get_post_meta($post->ID, 'price', true);
      echo ' <div class="col-s-3"><h3>'.get_the_title( ).'</h3><div><p>'.get_the_excerpt().'</p><p class="price">'.'€'.$price.'</p></div><div class=media><img src="'.$image[0].'"></div></div>';
      endwhile; // end of the loop.

    ?>
   </div>
 </div>


<?php get_footer(); ?>
