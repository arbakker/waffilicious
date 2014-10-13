<?php
/**
 * Template Name: Events page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>


<?php
echo '<div class="panel-group" id="accordion">';
$query = new WP_Query( array(
  'post_type' => 'event',
  'posts_per_page' => -1,
  'orderby' => 'meta_value_num',
  'meta_key' =>'event-sort-date',
  'order' => 'ASC' )
);
$posts = $query->get_posts();
$filter_post=[];
foreach($posts as $post) {
    $postID=get_the_ID();
    if (get_post_field( 'event-start-date', $postID )>time() ){
      $filter_post[]=$post;
}}

foreach($filter_post as $post){

$image = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'single-post-thumbnail' );
$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;
$form="";
$script="";

$thumbnail=get_the_post_thumbnail( $postID, 'thumbnail' );
$date=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'F j, Y' );


$start_day=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'j' );
$start_month=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'M' );
$end_day=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-end-date', $postID ) ), 'j' );
$end_month=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-end-date', $postID ) ), 'M' );


$start_date=get_post_field( 'event-start-date', $postID );

$end_date=get_post_field( 'event-end-date', $postID );

$sort_date=get_post_field('event-sort-date', $postID);

$deadline=get_post_field( 'event-deadline', $postID );
$location=get_post_field( 'event-venue', $postID );


$button_register='<button class="register btn-inline '.$name.'">Register</button>';
$button_unregister='<button class="unregister btn-inline '.$name.'">Unregister</button>';
$message_register='<p class="registration '.$postID.'" ><i class="fa registration fa-check-square-o fa-2x"></i>'."    Registered</p>";
$message_unregister='<p class="registration '.$postID.'"><i class="fa fa-square-o fa-2x registration"></i>'."    Not registered</p>";


$alert= '<div id="dismiss-'.$name.'" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss-'.$name.'" >x</button><p> %s!</p></div>';
if ($registered == "false"){
  $registered_string=$message_unregister;
  $button='<button class="register btn-inline '.$name.'">Register</button>'.'<button style="display:none;" class="unregister btn-inline '.$name.'">Unregister</button>';
  $message= 'You have been registered for '.$title;
  $alert= sprintf($alert, $message);
}
else{
  $registered_string=$message_register;
  $alert= '<div id="dismiss-'.$name.'" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss-'.$name.'" >x</button><p> %s!</p></div>';
  $button='<button style="display:none;" class="register btn-inline '.$name.'">Register</button>'.'<button class="unregister btn-inline '.$name.'">Unregister</button>';
  $message= 'You have been unregistered for ' . $title;
  $alert= sprintf( $alert, $message);
}

// Do not show event when start date of event has already passed
if (get_post_field( 'event-start-date', $postID )>time() ){
  // Do not show registration buttons when deadline of registration has passed
  if (get_post_field( 'event-deadline', $postID )<time() ){
    $button='<div class="alert alert-dismissable" role="alert" ><button data-dismiss-target=".alert" class="close">x</button><p>Deadline for registration has passed</p></div>';
 }
 ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <span class="badge alert-success">
      <?php

                      echo $start_day;


                  ?>
                  <?php

                      echo $start_month;

                  ?>
      </span>



    <h1 class="panel-title">


      <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $postID; ?>">
   <?php the_title(); ?>
      </a>

    </h1>

  </div>
  <div id="<?php echo $postID; ?>" class="panel-collapse collapse">
    <div class="panel-body">

      <row>
        <div class="col-xs-4 col-md-2">
          <div class="media">
                <?php echo $thumbnail ;?>
              </div>
        </div>
        <div class="col-md-8">
      <p>
        <?php echo the_excerpt(); ?>
      </p>
    </div>
    <div clas="col-md-2">
      <p class="text-right">
        sadglaoa
      </p>
    </div>
    </div>
  </div>
</div>




 <?php
}
}
?>





</div>


</main>


<?php get_footer(); ?>

<?php
