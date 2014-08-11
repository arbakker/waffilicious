<?php
/**
 * Template Name: Gallery page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>
 <main class="container" role="main">
 <div class="row">

  <?php query_posts( 'post_type=gallery'); ?>
  <?php while ( have_posts() ) : the_post();

     $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
    echo ' <div class="col-s-3"><div class=media><img src="'.$image[0].'"></div></div>';
    endwhile; // end of the loop. ?>

   </div>
 </div>


<?php get_footer(); ?>
