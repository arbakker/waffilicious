<?php get_header(); ?>

 <div class="row no-gutter">

  <?php query_posts( 'post_type=gallery');
  $counter = 0;
   ?>
  <?php while ( have_posts() ) : the_post();

     $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
    echo ' <div class="col-s-3">'.'<a class="divlink" href="' . get_permalink($recent["ID"]).'"><div class="card">'.'<h3>' .get_the_title().' </h3>'.
    '<div class=media><div></div><img src="'.$image[0].'"></div></div></a></div>';
    $counter++;
    if ($counter==4){
      echo '</div><div class="row no-gutter">';
    }
    endwhile; // end of the loop. ?>

   </div>
 </div>

</main>
<?php get_footer(); ?>
