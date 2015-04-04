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

if (count($posts)==0){
  ?>
 <h1>There is nothing here</h1>
 <p>There are no scheduled events.</p>
  <?php
}

foreach($filter_post as $post){
setup_postdata( $post );
$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);

$name=$post->post_name;
$title=$post->post_title;
$form="";
$script="";

$thumbnail=get_the_post_thumbnail( $postID, 'medium' );
$thumbnail=str_replace( 'class="', 'class="img-thumbnail img-responsive img-event ', $thumbnail );
$query_start_date= get_post_field( 'event-start-date', $postID );
$query_end_date= get_post_field( 'event-end-date', $postID );
$date=get_date_from_gmt( date( 'Y-m-d H:i:s',$query_date ), 'F j, Y' );

$start_day=get_date_from_gmt( date( 'Y-m-d H:i:s',$query_start_date ), 'j' );
$start_month=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_start_date ), 'M' );
$start_month_full=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_start_date ), 'F' );
$end_day=get_date_from_gmt( date( 'Y-m-d H:i:s',$query_end_date), 'j' );
$end_month=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_end_date ), 'M' );
$end_month_full=get_date_from_gmt( date( 'Y-m-d H:i:s', $query_end_date ), 'F' );

$sort_date=get_post_field('event-sort-date', $postID);
$deadline=get_post_field( 'event-deadline', $postID );
$daystodeadline=intval(($deadline - time())/(3600*24));

$location=get_post_field( 'event-venue', $postID );
$price=get_post_field( 'price', $postID );

$icon_register='<i class="fa text-right registered loggedin  '.$postID.'  fa-check-square-o fa-lg"></i>';
$icon_unregister='<i class="fa text-right notregistered loggedin '.$postID.' fa-square-o fa-lg "></i>';

$fulldate=get_event_date_string($query_start_date,$start_day,$start_month_full,$query_end_date,$end_day,$end_month_full);

$members = get_post_meta($post->ID, 'members', true);
$guest_players = get_post_meta($post->ID, 'guest_players', true);


if (!$guest_players){
  $nr_guest=0;
}else{
  $nr_guest=count($guest_players);
}


$total_players=count($members)+$nr_guest;
$nr_members = $total_players;



if (! $registered){
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
    $button='<button style="display:none;" class="btn ladda-button btn-default unregister  topdot5 loggedin '.$name." ".$postID.' pull-right" name="'.$name.'" data-style="expand-left" data-spinner-color="#333"><span class="ladda-label">Unregister</span></button>'.
            '<div class="input-group  loggedin '.$name.'">
            <input data-toggle="tooltip" data-placement="left" title="Additional details for registration" type="text" id="registration-input-'.$name.'" class="form-control">
            <span class="input-group-btn">
            <button class="btn ladda-button btn-default register '.$name.'" type="button" data-style="expand-left" data-spinner-color="#333" name="'.$name.'"><span class="ladda-label">Register</span></button>
            </span>
            </div>';
          }else{
            $button="";
          }

    $weeks = floor($daystodeadline/7);
    $days= $daystodeadline % 7;

    $alert_string=waf_alert_string($days,$weeks);


    $alert='<div class="alert  alert-warning fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
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
    $button='<button  class="btn ladda-button btn-default unregister loggedin '.$name." ".$postID.' pull-right topdot5" data-style="expand-left" data-spinner-color="#333" name="'.$name.'" ><span class="ladda-label">Unregister</span></button>'.
            '<div class="input-group loggedin '.$name.'" style="display:none;">
            <input type="text" id="registration-input-'.$name.'" class="form-control">
            <span class="input-group-btn">
            <button class="btn ladda-button btn-default register '.$name.'" type="button" data-style="expand-left" data-spinner-color="#333"  name="'.$name.'"><span class="ladda-label">Register</span></button>
            </span>
            </div>';
  }
}

// Do not show event when start date of event has already passed
if (get_post_field( 'event-start-date', $postID )>time() ){
  ?>
  <div class="panel panel-default event" name="<?php echo $name;?>" id-event="<?php echo $postID;?>" >
    <div class="panel-heading">
      <div class="label event" style="float:left;">
        <time ><strong>  <?php
          echo $start_day;
          ?>
          <?php
          echo $start_month;
          ?></strong></time>
      </div>
      <h1 class="panel-title"  data-toggle="collapse" data-parent="#accordion" data-target="#<?php echo $postID; ?>">



        <a class="accordion-toggle">
          <?php the_title();?>
        </a>

        <?php echo $registered_string ;?>
      </h1>
    </div>
  <div id="<?php echo $postID; ?>" class="panel-collapse collapse">
    <div class="panel-body">
      <a name="<?php echo $name;?>" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $postID; ?>"></a>
       <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-2">
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
              <?php edit_post_link( __( '&nbsp;<i class="fa fa-edit"></i></i>'), '<span class=" ">', '</span>' ); ?>
              <div class="top1">

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
          <div class="col-xs-12 col-sm-8 col-md-10">
            <ul class="nav nav-tabs" role="tablist">
              <li class="active"><a href="#event_<?php echo $name; ?>" role="tab" data-toggle="tab"><?php echo custom_taxonomies_term();?></a></li>
              <?php
              if (is_user_logged_in()){
                ?>
              <li class="loggedin"><a href="#people_<?php echo $name; ?>" role="tab" data-toggle="tab">People
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
                        if (! $registered){
                      ?>
                              style="display:none"
                          <?php } ?>
                                      class=" reg-details <?php echo " ".$postID;  ?>">
                                      <div class="row">
                                        <div class="col-md-12">
                                        <div class="btn-group pull-right btn-group-details btn-group-sm loggedin">


                                          <button type="button" style="display:none;" id="submit-details-<?php echo $postID; ?>" class="btn btn-default ladda-button update-button" data-style="expand-left"  data-spinner-color="#333" data-toggle="tooltip" data-placement="left" title="Update your registration details"><span class="ladda-label">Update</span></button>
                                          <button type="button" style="display:none;" id="cancel-details-<?php echo $postID; ?>" class="btn btn-default">Cancel</button>
                                        </div>
                                        <button type="button" id="edit-details-<?php echo $postID; ?>" class="btn btn-default btn-sm pull-right btn-edit-details loggedin" data-toggle="tooltip" data-placement="left" title="Click to edit your registration details">
                                          <i class="fa fa-pencil-square-o fa-lg"></i>
                                        </button>
                                      </div>
                                      </div>
                                      <textarea id="form-details-<?php echo $postID; ?>" class="form-control loggedin" rows="3" disabled="disabled" data-toggle="tooltip" data-placement="left" title="Edit your registration details"><?php echo  get_post_meta( $postID, 'members', true )["$user_id"];?></textarea>
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
            <div class="tab-pane loggedin" id="people_<?php echo $name; ?>">
              <table class="table top1 table-striped" >
              <?php
              $all_email="";
              foreach ($members as $key => $value){
                $user_id=intval($key);
                $user = get_userdata( $user_id );
                $email=$user->user_email;
                $all_email .= $email.";";


                $registered_email=$registered_email+$email+';';

                echo   "<tr user='".$user_id."'><td>".  $user->display_name. "</td><td>".  $user->user_email ."</td></tr>";
              }
                  ?>
              </table>
              <table class="table top1 table-striped" >

              <?php
              if ($nr_guest>0){
                ?>

                  <caption><h4>Guest players</h4></caption>
                  <tbody>
                  <?php
                  foreach ($guest_players as $key => $value){

                    $all_email .= $value[0].";";

                    echo   "<tr><td>".  $key. "</td><td>".  $value[0] ."</td></tr>";
                  }
                  echo "</tbody>";

              }
              echo "</table>";
              if ($total_players>0){
              ?>


              <a href="#"   data-target="#modal-<?php echo $postID; ?>" data-toggle="modal" type="button" class="btn btn-default btn-sm pull-right btn-copy-email"  id="copy-email-<?php echo $postID; ?>"><i class="fa fa-clipboard"></i></a>


              <div class="modal fade" class="exampleModal" id="modal-<?php echo $postID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <h4 class="modal-title" id="exampleModalLabel">Copy email addresses</h4>
                    </div>
                    <div class="modal-body">
                      <form role="form">
                        <div class="form-group">
                          <label for="email_addresses_<?php echo $postID; ?>" class="control-label">Email addresses:</label>
                          <textarea autofocus="autofocus"  class="form-control email_addresses" id="email_addresses_<?php echo $postID; ?>" ><?php echo $all_email; ?></textarea>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                  </div>
                </div>
              </div>
              <?php

            }
            ?>

            </div>
            <?php }
            ?>
            </div>
          </div>
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
