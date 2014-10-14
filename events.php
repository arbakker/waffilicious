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

$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;
$title=$post->post_title;
$form="";
$script="";

$thumbnail=get_the_post_thumbnail( $postID, 'medium' );
$thumbnail=str_replace( 'class="', 'class="img-rounded img-responsive img-event ', $thumbnail );
$date=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'F j, Y' );


$start_day=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'j' );
$start_month=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'M' );
$start_month_full=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-start-date', $postID ) ), 'F' );
$end_day=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-end-date', $postID ) ), 'j' );
$end_month=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-end-date', $postID ) ), 'M' );
$end_month_full=get_date_from_gmt( date( 'Y-m-d H:i:s', get_post_field( 'event-end-date', $postID ) ), 'F' );

$start_date=get_post_field( 'event-start-date', $postID );

$end_date=get_post_field( 'event-end-date', $postID );

$sort_date=get_post_field('event-sort-date', $postID);

$deadline=get_post_field( 'event-deadline', $postID );
$daystodeadline=intval(($deadline - time())/(3600*24));

$location=get_post_field( 'event-venue', $postID );
$price=get_post_field( 'price', $postID );

$button_register='<button class="register btn-inline '.$name.'">Register</button>';
$button_unregister='<button class="unregister btn-inline '.$name.'">Unregister</button>';
$message_register='<i class="fa text-right registered  '.$postID.'  fa-check-square-o fa-2x"></i>';
$message_unregister='<i class="fa text-right notregistered  '.$postID.' fa-square-o fa-2x "></i>';

if ($start_date!=$end_date){
  if ($start_month===$end_month){
    $fulldate=$start_day."-".$end_day." ".$end_month_full;
  }else{
    $fulldate=$start_day." ".$start_month_full."-".$end_day." ".$end_month_full;
  }


}else{
  $fulldate=$start_day." ".$start_month_full;
}




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


if ($daystodeadline<0){
  $alert='<div class="alert  alert-danger fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
  <strong>Holy guacamole!</strong> Registration deadline has passed!
</div>';
$button='<button  class="btn btn-default top1 btn-unregister">Unregister</button>';



}else{
  $alert='<div class="alert  alert-success fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
  <strong> '.$daystodeadline.'</strong> days left to sign up for '.$title.'!
</div>';
  $button='
  <div class="input-group bottom1 top1">
    <input type="text" id="registration-input" class="form-control">
    <span class="input-group-btn">
      <button class="btn btn-default  register '.$name.'" type="button">Register</button>
    </span>
  </div>';
}



// Do not show event when start date of event has already passed
if (get_post_field( 'event-start-date', $postID )>time() ){


 ?>

<div class="panel panel-default" name="<?php echo $name;?>" >
  <div class="panel-heading">
    <h1 class="panel-title">
      <span class="badge alert-success">
    <?php
    echo $start_day;
    ?>
    <?php
    echo $start_month;
    ?>
      </span>
      <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $postID; ?>">
    <?php the_title(); ?>
      </a>
    <?php if ($daystodeadline<0) { ?>
      <span class="label label-danger">Closed</span><?php
    }else{ ?>
      <span class="label label-success"><?php echo intval(($deadline - time())/(3600*24)) ;?>  days left</span>
    <?php } ?>
    <?php echo $registered_string ;?>
    </h1>
  </div>
  <div id="<?php echo $postID; ?>" class="panel-collapse collapse">
    <div class="panel-body">
      <a name="<?php echo $name;?>" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $postID; ?>"></a>
       <div class="row">
        <div class="col-xs-4 col-md-2">
          <div class="row">
            <div class="col-md-12">
              <div>
                <a href="<?php the_permalink()?>">
                  <?php echo $thumbnail ;?>
                </a>
              </div>
            </div>
          </div>
          <div class="row top2">
            <div class="col-md-12">
              <div>
                <ul class="list-group">
                  <li class="list-group-item details"><i class="fa fa-calendar-o"></i>&nbsp;<?php echo $fulldate;?></li>
                  <li class="list-group-item details"><i class="fa fa-map-marker"></i>&nbsp;<?php echo $location;?></li>
                <?php if (! empty($price)){  ?>
                  <li class="list-group-item details"><i class="fa fa-euro"></i>&nbsp;<?php echo $price;?></li>
                <?php
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
        </div>
          <div class="col-xs-8 col-md-10">
            <ul class="nav nav-tabs" role="tablist">
              <li class="active"><a href="#event_<?php echo $name; ?>" role="tab" data-toggle="tab">Event</a></li>
              <li><a href="#people_<?php echo $name; ?>" role="tab" data-toggle="tab">People</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="event_<?php echo $name; ?>">
                <div class="row top2">
                  <div class="col-md-12">
                  <?php
                  $content = get_post_field('post_content', $my_postid);
                  echo $alert;
                  echo $content;
                  echo $button;
                  ?>

                </div>
                </div>
              </div>
              <div class="tab-pane" id="people_<?php echo $name; ?>">

              </div>
            </div>



          </div>
        </div>
      </div>
    </div>
  </div>







<!--

  <?php if ($daystodeadline<0) {
    ?><div class="alert alert-danger fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <strong>Holy guacamole!</strong> Registration deadline has passed you lazy nitwit!
  </div><?php
  }else{
    ?><div class="alert alert-warning fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <strong>Holy guacamole!</strong> <?php echo intval(($deadline - time())/(3600*24)) ;?> days left to register!
  </div>
    <?php
  }    ?>

-->



 <?php
}
}
?>





</div>


</main>


<?php get_footer(); ?>

<?php
