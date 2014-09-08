<?php
/**
 * Template Name: Event page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>
<?php
// Do not show event when start date of event has already passed
//if (get_post_field( 'event-start-date', $postID )>time() ){
  // TODO: SHOW only message to user that event has expired. Perhaps show links to foto's.
  // Do not show registration buttons when deadline of registration has passed
  // TODO: SHOW alert to user that deadline has passed.
//  if (get_post_field( 'event-deadline', $postID )<time() ){

$postID = get_the_ID();
$thumbnail=get_the_post_thumbnail( $postID, 'large' );
$start_day=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'j' );
$start_month=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'M' );
$end_day=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-end-date', $postID ) ), 'j' );
$end_month=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-end-date', $postID ) ), 'M' );
$deadline=get_post_field( 'event-deadline', $postID );
$location=get_post_field( 'event-venue', $postID );
$start_date=get_post_field( 'event-start-date', $postID );
$end_date=get_post_field( 'event-end-date', $postID );
$user_id = get_current_user_id();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;


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




?>


<div class="row">
  <div class="col-s-12">
  <?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="row" name="<?php echo $name;?>" id="<?php echo $postID; ?>">
        <div class="col-m-6">
          <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
          </header><!-- .entry-header -->
          <div class="event-date">

            <i class="fa fa-calendar-o  "></i>
          </space>
            <?php
            if ($start_date==$end_date){
              echo $start_day. " / ". $start_month;
            }
            else{
              echo $start_day. " / ".$start_month." - ".$end_day. " / ".$end_month  ;
            }
            ?>


          </div>
          <div class="entry-content">
              <?php the_content(); ?>
              <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'minim2' ), 'after' => '</div>' ) ); ?>
          </div><!-- .entry-content -->
          <div class="event-info">
            <i class="fa fa-map-marker"></i> <?php echo $location;?>
          </div>

        </div>
<div class="col-xs-6">
  <div class="media">
    <?php echo $thumbnail ;?>
  </div>
</div>
        <div class="col-m-6">
        <p><?php echo $registered_string ;?></p>
        </div>
        <?php echo $button ;?>
      </div>
      <div class="row">
        <div class="col-m-6">

        </div>

      </div>
      <div class="row">
        <div class="col-xs-12">
        <div class="entry-meta">
          <?php waf_posted_on(); ?>
          <?php
        echo " in " . custom_taxonomies_terms_links();
          ?>
          <?php edit_post_link( __( '<i class="fa registration fa-edit fa-2x"></i>'), '<span class="edit-link">', '</span>' ); ?>
        </div><!-- .entry-meta -->
      </div>
      </div>
    </article><!-- #post-<?php the_ID(); ?> -->



  <?php endwhile; // end of the loop. ?>

  </div>
</div>
</main>
<?php get_footer(); ?>
<?php
