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
/*
echo '<a href="#" class="modal" data-modal-target="#modal" data-modal-modal="button">Launch modal overlay</a>';
echo '<div id="modal" class="hidden">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum.
            </p>
            <p>
                <button role="button">Click to close.</button>
            </p>
        </div>';
*/


$counter=0;
$loop = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => -1, 'orderby' => 'event-start-date', 'order' => 'ASC' ) );
while ( $loop->have_posts() ) : $loop->the_post();
$image = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'single-post-thumbnail' );
$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;
$form="";
$script="";
$title=get_the_title();

$button_register='<button class="register btn-inline '.$name.'">Register</button>';
$button_unregister='<button class="unregister btn-inline '.$name.'">Unregister</button>';
$message_register='<span><i class="fa registration fa-check-square-o fa-2x"></i>'."Registered</span>";
$message_unregister='<span><i class="fa fa-square-o fa-2x registration"></i>'."Not registered</span>";


$alert= '<div id="dismiss-'.$name.'" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss-'.$name.'" >x</button><p> %s!</p></div>';
if ($registered == "false"){
  $registered_string=$message_unregister;
  $button='<button style="display:inline;" class="register btn-inline '.$name.'">Register</button>'.'<button style="display:none;" class="unregister btn-inline '.$name.'">Unregister</button>';
  $message= 'You have been registered for '.$title;
  $alert= sprintf($alert, $message);
}
else{
  $registered_string=$message_register;
  $alert= '<div id="dismiss-'.$name.'" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss-'.$name.'" >x</button><p> %s!</p></div>';
  $button='<button style="display:none;" class="register btn-inline '.$name.'">Register</button>'.'<button style="display:inline ;" class="unregister btn-inline '.$name.'">Unregister</button>';
  $message= 'You have been unregistered for ' . $title;
  $alert= sprintf( $alert, $message);
}

echo '<div class="col-s-3">'. '<div class="card" id='.$postID.' name='. $name .'>'.'<h3>'.get_the_title().'</h3><div class=media><img src="'.$image[0].'"></div><p id="event-date">'. get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'F j, Y' ).'</p><p class="registered '.$name.'" >'.$registered_string." ".$button.'</p></div></div>';


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
