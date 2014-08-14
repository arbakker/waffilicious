<?php
/**
 * Template Name: Events page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>
 <main class="container" role="main">
 <div class="row">

  <?php
/*
 query_posts( 'post_type=event');
  $counter = 0;
   ?>
  <?php while ( have_posts() ) : the_post();

     $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
    echo ' <div class="col-s-3"><h1>'.get_the_title().'</h1><div class=media><img src="'.$image[0].'"></div><p>'.get_the_excerpt().'</p></div>';
    $counter++;
    if ($counter==4){
      echo '</div><div class="row">';
    }
  endwhile; // end of the loop.*/










$counter=0;
$loop = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => -1, 'orderby' => 'event-start-date', 'order' => 'ASC' ) );
while ( $loop->have_posts() ) : $loop->the_post();
$image = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'single-post-thumbnail' );
$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;


$script="<script>
jQuery().ready(function() {
jQuery('#".$name."').click(function() {
jQuery.ajax({
       type:". '"POST",
       url: ajaxurl,
       data: "action=newmember&id='.$postID.'&member='.$user_id.'",
       success: function(data){
            if(data.status == "success"){
        alert("Thank you for subscribing!");
      }
       }
   });
})});
</script>';
echo $script;

//'<a class="divlink" href="' . get_permalink().'">'.
echo '<div class="col-s-3">'. '<div class="card">'.'<h3>'.get_the_title().'</h3><div class=media><img src="'.$image[0].'"></div><p id="event-date">'. get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'F j, Y' ).'</p><p>Registered:'.$registered.'</p><form><input type="submit" id="'.$name.'" value="Submit"></form></div></div>';


$counter++;
if ($counter==4){
  echo '</div><div class="row">';
}

endwhile; wp_reset_query();
  ?>

   </div>
 </div>


<?php get_footer(); ?>

<?php
