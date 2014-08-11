<?php
/**
 * Template Name: Tournaments page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>
 <main class="container" role="main">
 <div class="row">

  <?php query_posts( 'post_type=tournaments');
  $counter = 0;
   ?>
  <?php while ( have_posts() ) : the_post();

     $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
    echo ' <div class="col-s-3"><h1>'.get_the_title().'</h1><div class=media><img src="'.$image[0].'"></div><p>'.get_the_excerpt().'</p></div>';
    $counter++;
    if ($counter==4){
      echo '</div><div class="row">';
    }
    endwhile; // end of the loop. ?>

   </div>
 </div>


<?php get_footer(); ?>
