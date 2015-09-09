<?php get_header(); ?>
<div class="row">
  <div class="col-md-12">
<?php
if(have_posts()): while(have_posts()): the_post();

$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;
$title=$post->post_title;
$form="";
$script="";
$thumbnail=get_the_post_thumbnail( $postID, 'medium' );
$thumbnail=str_replace( 'class="', 'class="img-rounded img-responsive img-event ', $thumbnail );
$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'large' )[0];


// Get event dates
$query_start_date= get_post_field( 'event-start-date', $postID );
$query_end_date= get_post_field( 'event-end-date', $postID );
$iso_start_date = date( 'Y-m-d\TH:i',$query_start_date )."</br>";
$iso_end_date= date( 'Y-m-d\TH:i',$query_end_date )."</br>";
$fulldate=get_event_date_string($query_start_date,$query_end_date);

$sort_date=get_post_field('event-sort-date', $postID);
$deadline=get_post_field( 'event-deadline', $postID );
$daystodeadline=intval(($deadline - time())/(3600*24));
// Get other event information
$external=get_post_field( 'event-external', $postID );
$location=get_post_field( 'event-venue', $postID );
$price=get_post_field( 'price', $postID );
$icon_register='<i class="fa text-right registered  '.$postID.'  fa-check-square-o fa-lg"></i>';
$icon_unregister='<i class="fa text-right notregistered  '.$postID.' fa-square-o fa-lg "></i>';
$fulldate=get_event_date_string($start_date,$end_date);
$members = get_post_meta($post->ID, 'members', true);
$guest_players = get_post_meta($post->ID, 'guest_players', true);


$location=get_post_field( 'event-venue', $postID );
$external=get_post_field( 'event-external', $postID );
$address=get_post_field( 'event-address', $postID );
$postal=get_post_field( 'event-postal', $postID );
$locality=get_post_field( 'event-locality', $postID );
$country=get_post_field( 'event-country', $postID );
$organizer=get_post_field( 'event-organizer', $postID );
$organizer_url=get_post_field( 'event-url', $postID );



if (!$guest_players){
  $nr_guest=0;
}else{
  $nr_guest=count($guest_players);
}

if (!$members){
  $nr_member=0;
}else{
  $nr_member=count($members);
}

$total_players=$nr_member+$nr_guest;


$nr_members = $total_players;

if (!$registered){

  if (! is_user_logged_in() && $external!=="on"){
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
    if (is_user_logged_in() && $external!=="on"){

    $button='<button style="display:none;" class="btn btn-default unregister  topdot5 '.$name." ".$postID.' pull-right" name="'.$name.'">Unregister</button>'.
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
  if (! is_user_logged_in() && $external!=="on"){

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
    $button='<button  class="btn btn-default unregister '.$name." ".$postID.' pull-right topdot5" name="'.$name.'" >Unregister</button>'.
            '<div class="input-group '.$name.'" style="display:none;">
            <input type="text" id="registration-input-'.$name.'" class="form-control">
            <span class="input-group-btn">
            <button class="btn btn-default register '.$name.'" type="button" name="'.$name.'">Register</button>
            </span>
            </div>';
  }
}


  ?>

       <div class="row event" itemscope itemtype="<?php
       if (custom_taxonomies_term()=="Activity"){
         echo "https://schema.org/SocialEvent";
       }else{
         echo "https://schema.org/SportsEvent";
       }
       ?>" name="<?php echo $name;?>" id-event="<?php echo $postID;?>">
        <div class="col-xs-12 col-sm-4 col-md-3">
          <div class="row">
            <div class="col-md-12">
              <h2 itemprop="name">
                <?php the_title(); ?>
              </h2>
              <div>
                <a href="<?php the_permalink()?>">
                  <?php echo $thumbnail ;?>
                   <meta itemprop="image"content="<?php echo $imageurl;?>" >
                </a>
              </div>
            </div>
          </div>
          <div class="row top1">
            <div class="col-md-12">
              <?php edit_post_link( __( '&nbsp;<i class="fa fa-edit"></i></i>'), '<span class=" ">', '</span>' ); ?>
              <div class="top1">
                <ul class="list-group">
                  <li class="list-group-item details"><i class="fa fa-calendar-o"></i>
                    <meta itemprop="startDate" content="<?php echo $iso_start_date;?>">
                    &nbsp;<?php echo $fulldate;?></li>
                    <meta itemprop="endDate" content="<?php echo $iso_end_date;?>">
                  </li>
                  <li class="list-group-item details"><i class="fa fa-map-marker"></i>&nbsp;<?php echo $location;?></li>
                <?php if (! empty($price)){  ?>
                  <li class="list-group-item details"><i class="fa fa-euro"></i>&nbsp;<?php echo $price;?></li>
                <?php
                }
                ?>
              </ul>
              <div class="dropdown topdot5">
                <button class="btn btn-default dropdowntoggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Add to calendar
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <li><a href="/wp-content/themes/<?php echo get_template(); ?>/ical-generator.php?eventid=<?php echo $postID; ?>">Download ical</a></li>
                  <!--<li><a href="#">Another action</a></li>-->
                </ul>
              </div>

            </div>
          </div>
        </div>
        </div>
          <div class="col-xs-12 col-sm-8 col-md-9">
            <ul class="nav nav-tabs" role="tablist">
              <li class="active"><a href="#event_<?php echo $name; ?>" role="tab" data-toggle="tab"><?php echo custom_taxonomies_term();?></a></li>
              <?php
              if (is_user_logged_in() && $external!=="on"){
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
                  the_content();
                  ?>

                  <div class="row top2">
                    <div class="col-md-6  col-xs-6">
                      <h4>Location</h4>
                      <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                        <?php
                        if ($location){
                          ?>
                          <div itemprop="name"><?php echo $location;?></div>
                          <?php
                        }
                        ?>
                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                        <?php
                        if ($address){
                          ?>
                          <span  class="addressitem" itemprop="streetAddress"><?php echo $address;?></span>
                          <?php
                        }
                        if ($postal){
                          ?>
                        </br><span class="addressitem"  itemprop="postalCode"><?php echo $postal;?> </span>
                          <?php
                        }
                        if ($locality){
                          ?>
                        </br><span class="addressitem" itemprop="addressLocality"><?php echo $locality;?></span>

                          <?php
                        }
                        if ($country=="the Netherlands"){
                            ?>
                              <meta itemprop="addressCountry" content="<?php echo $country;?>">
                            <?php
                          }else {
                            ?>
                          </br><span class="addressitem"  itemprop="addressCountry"><?php echo $country;?></span>
                            <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-xs-6">
                      <?php
                      if ($organizer ||$organizer_url ){
                      ?>
                      <h4>Organization</h4>
                      <?php

                      if ($organizer){
                        ?>


                        <div itemprop="organizer" itemscope itemtype="http://schema.org/Organization">

                          <span itemprop="name"><?php echo $organizer;?></span>

                          </div>
                        <?php
                      }
                      if ($organizer_url){

                        ?>

<a href="<?php echo $organizer_url ?>" itemprop="url"><?php the_title(); ?></a>

                        <?php

                      }
                    }
                      ?>

                  </div>
                  </div>



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

                        if (!$registered ){
                      ?>
                              style="display:none"
                          <?php } ?>
                                      class=" reg-details <?php echo " ".$postID;  ?>">
                                      <div class="row">
                                        <div class="col-md-12">
                                        <div class="btn-group pull-right btn-group-details btn-group-sm">


                                          <button type="button" style="display:none;" id="submit-details-<?php echo $postID; ?>" class="btn btn-default ladda-button update-button" data-style="expand-left"  data-spinner-color="#333" data-toggle="tooltip" data-placement="top" title="Update your registration details"><span class="ladda-label">Update</span></button>
                                          <button type="button" style="display:none;" id="cancel-details-<?php echo $postID; ?>" class="btn btn-default">Cancel</button>
                                        </div>
                                        <button type="button" id="edit-details-<?php echo $postID; ?>" class="btn btn-default btn-sm pull-right btn-edit-details" data-toggle="tooltip" data-placement="left" title="Click to edit your registration details">
                                          <i class="fa fa-pencil-square-o fa-lg"></i>
                                        </button>
                                      </div>
                                      </div>
                                      <textarea id="form-details-<?php echo $postID; ?>" class="form-control" rows="3" disabled="disabled" data-toggle="tooltip" data-placement="top" title="Edit your registration details"><?php echo  get_post_meta( $postID, 'members', true )["$user_id"];?></textarea>
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
            if (is_user_logged_in() && $external!=="on"){
            ?>
            <div class="tab-pane" id="people_<?php echo $name; ?>">
              <table class="table top1" >
              <?php
                    $all_email="";
                    foreach ($members as $key => $value){
                        $user_id=intval($key);
                        $user = get_userdata( $user_id );
                        $email=$user->user_email;
                        $all_email .= $email.";";
                        echo   "<tr user='".$user_id."'><td>".  $user->display_name. "</td><td>".  $user->user_email ."</td></tr>";

                      }
                  ?>
              </table>
              <?php

              if ($nr_guest>0){
                ?>
                <table class="table top1 table-striped" >
                  <caption><h4>Guest players</h4></caption>
                  <tbody>
                  <?php
                  foreach ($guest_players as $key => $value){

                    $all_email .= $value[0].";";

                    echo   "<tr><td>".  $key. "</td><td>".  $value[0] ."</td></tr>";
                  }
                  echo "</tbody></table>";

              }
              if ($total_players>0){
              ?>


              <a href="#"  data-target="#exampleModal_<?php echo $postID; ?>" data-toggle="modal" type="button" class=" btn btn-default btn-sm pull-right btn-copy-email"  id="copy-email-<?php echo $postID; ?>"><i class="fa fa-clipboard"></i></a>


              <div class="modal" class="exampleModal" id="exampleModal_<?php echo $postID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
 <?php

?>
</div>
</div>
<?php endwhile; endif;
get_footer();
?>
