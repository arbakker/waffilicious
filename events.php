<?php
/**
 * Template Name: Events page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php
get_header();




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
    }
}

foreach($filter_post as $post){

$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;
$title=$post->post_title;
$form="";
$script="";

$thumbnail=get_the_post_thumbnail( $postID, 'medium' );
$thumbnail=str_replace( 'class="', 'class="img-thumbnail img-responsive img-event ', $thumbnail );
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

$icon_register='<i class="fa text-right registered  '.$postID.'  fa-check-square-o fa-lg"></i>';
$icon_unregister='<i class="fa text-right notregistered  '.$postID.' fa-square-o fa-lg "></i>';

$fulldate=get_event_date_string($start_date,$start_day,$start_month_full,$end_date,$end_day,$end_month_full);

$membersstring = get_post_meta($post->ID, 'members', true);

if (!empty($membersstring)){
    $members=explode(',', $membersstring);
    $nr_members = count($members);
}else{
  $nr_members = 0;
}

if ($registered=='false'){
  if (! is_user_logged_in()){
    $registered_string="";
  }else{
    $registered_string=$icon_unregister;
  }
  if ($daystodeadline<0){
    $button="";
    $alert='<div class="alert  alert-danger fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            Registration deadline has passed!
            </div>';
  }else{
    if (is_user_logged_in()){
    $button='<button style="display:none;" class="btn btn-default unregister  topdot5 '.$name.' pull-right" name="'.$name.'">Unregister</button>'.
            '<div class="input-group  '.$name.'">
            <input type="text" id="registration-input-'.$name.'" class="form-control">
            <span class="input-group-btn">
            <button class="btn btn-default register '.$name.'" type="button" name="'.$name.'">Register</button>
            </span>
            </div>';
          }else{
            $button="";
          }

    $weeks = floor($daystodeadline/7);
    $days= $daystodeadline % 7;

    $alert_string=waf_alert_string($days,$weeks);


    $alert='<div class="alert  alert-success fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            '.    $alert_string .'
            </div>';
  }
}else{
  if (! is_user_logged_in()){
    $registered_string="";
  }else{
    $registered_string=$icon_register;
  }
  if ($daystodeadline<0){
    $button="";
    $alert='<div class="alert  alert-danger fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    Registration deadline has passed!
    </div>';
  }else{
    $alert="";
    $button='<button  class="btn btn-default unregister '.$name.' pull-right topdot5" name="'.$name.'" >Unregister</button>'.
            '<div class="input-group '.$name.'" style="display:none;">
            <input type="text" id="registration-input-'.$name.'" class="form-control">
            <span class="input-group-btn">
            <button class="btn btn-default register '.$name.'" type="button" name="'.$name.'">Register</button>
            </span>
            </div>';
  }
}

// Do not show event when start date of event has already passed
if (get_post_field( 'event-start-date', $postID )>time() ){
  ?>
  <div class="panel panel-default event" name="<?php echo $name;?>" id-event="<?php echo $postID;?>" >
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
          <div class="row top1">
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
              <li class="active"><a href="#event_<?php echo $name; ?>" role="tab" data-toggle="tab"><?php echo custom_taxonomies_term();?></a></li>
              <?php
              if (is_user_logged_in()){
                ?>
              <li><a href="#people_<?php echo $name; ?>" role="tab" data-toggle="tab">People
                <?php
                echo '<span class="badge '.$name.'">'.$nr_members.'</span>';
                ?>
              </a></li><?php
            }
            ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="event_<?php echo $name; ?>">
                <div class="row top2">
                  <div class="col-md-12">
                  <?php
                  $content = get_post_field('post_content', $my_postid);
                  echo $content;
                  ?>
                  <hr>
                  <div class="row event-button">
                    <div class="col-md-12">
                      <?php
                      echo $alert;
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div <?php
                        if ($registered == "false"){
                      ?>
                              style="display:none"
                          <?php } ?>
                                      class=" reg-details <?php echo " ".$postID;  ?>">
                                      <div class="row">
                                        <div class="col-md-12">
                                        <div class="btn-group pull-right btn-group-details btn-group-sm">
                                          <button type="button" style="display:none;" id="submit-details-<?php echo $postID; ?>" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Update your registration details">Update</button>
                                          <button type="button" style="display:none;" id="cancel-details-<?php echo $postID; ?>" class="btn btn-default">Cancel</button>
                                        </div>
                                        <button type="button" id="edit-details-<?php echo $postID; ?>" class="btn btn-default btn-sm pull-right btn-edit-details" data-toggle="tooltip" data-placement="left" title="Click to edit your registration details">
                                          <i class="fa fa-pencil-square-o fa-lg"></i>
                                        </button>
                                      </div>
                                      </div>
                                      <textarea id="form-details-<?php echo $postID; ?>" class="form-control" rows="3" disabled="disabled" data-toggle="tooltip" data-placement="top" title="Edit your registration details"><?php echo  get_post_meta( $postID, 'details', true )["$user_id"];?></textarea>
                      </div>
                        <?php
                        echo $button;
                        ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (is_user_logged_in()){
            ?>
            <div class="tab-pane" id="people_<?php echo $name; ?>">
              <table class="table top1" >
              <?php
                    if ($nr_members>0){
                      for($i=0;$i<count($members);$i++) {
                        $user_id=intval($members[$i]);
                        $user = get_userdata( $user_id );
                        echo   "<tr user='".$user_id."'><td>".  $user->user_login. "</td><td>".  $user->user_email ."</td></tr>";
                        }
                      }
                  ?>
              </table>
            </div>
            <?php }
            ?>
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
