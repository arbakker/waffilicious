<?php get_header(); ?>
<div class="row">
  <div class="col-md-12">
<?php
if(have_posts()): while(have_posts()): the_post();
date_default_timezone_set('Europe/Amsterdam');
$user_id = get_current_user_id();
$postID = get_the_ID();
$registered=is_user_registered ($user_id, $postID);
$name=$post->post_name;
$title=$post->post_title;
$content = $post->post_content;
$form="";
$script="";
$thumbnail=get_the_post_thumbnail( $postID, 'medium' );
$thumbnail=str_replace( 'class="', 'class="img-rounded img-responsive img-event ', $thumbnail );
$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'large' )[0];


// Get event dates
$query_start_date= get_post_field( 'event-start-date', $postID );
$query_end_date= get_post_field( 'event-end-date', $postID );
$iso_start_date = date( 'Y-m-d\TH:i',$query_start_date );
$iso_end_date= date( 'Y-m-d\TH:i',$query_end_date );
$google_start_date=date( 'Ymd\THis',$query_start_date );
$google_end_date= date( 'Ymd\THis',$query_end_date );
$fulldate=get_event_date_string($query_start_date,$query_end_date);
$sort_date=get_post_field('event-sort-date', $postID);
$deadline=get_post_field( 'event-deadline', $postID );
// Get other event information
$external=get_post_field( 'event-external', $postID );
$location=get_post_field( 'event-venue', $postID );
$price=get_post_field( 'price', $postID );
$icon_register='<i class="fa text-right registered  '.$postID.'  fa-check-square-o fa-lg"></i>';
$icon_unregister='<i class="fa text-right notregistered  '.$postID.' fa-square-o fa-lg "></i>';
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

$alert_closed='<div class="alert  alert-danger fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
Registration closed!
</div>';
$alert_open='<div class="alert  alert-warning fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        '.   waf_alert_string($deadline) .'</div>';
// User not logged in
if (! is_user_logged_in()){
  // External event show deadline alerts
  if ($external){
    $registered_string="";
    $button="";
    // Registation closed
    if (time()>$deadline){
      $alert=$alert_closed;
    }
    // Registration still open
    else{
      $alert=$alert_open;
    }
  }
  // Internal event hide deadline alerts
  else{
    $registered_string="";
    $button="";
    $alert="";
  }
}
// User logged in
else{
  if (!$external){
      // User registered
      if ($registered){
        // Registation closed
        if (time()>$deadline){
          $button="";
        }
        // Registration still open
        else{
          $button=get_unreg_button($name,$postID);
        }
        $alert="";
        $registered_string=$icon_register;
      }
      // User not registered
      else{
        // Registation closed
        if (time()>$deadline){
            $button="";
            $alert=$alert_closed;
        }
        // Registration still open
        else{
          $alert=$alert_open;
          $button=get_reg_button($name,$postID);
        }
        $registered_string=$icon_unregister;
      }
    }
    else{
      $registered_string="";
      $button="";
      // Registation closed
      if (time()>$deadline){
        $alert=$alert_closed;
      }
      // Registration still open
      else{
        $alert=$alert_open;
      }
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
              <div class="dropdown topdot5 bottom1">
                <button class="btn btn-default dropdowntoggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Add to calendar
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <li><a href="/wp-content/themes/<?php echo get_template(); ?>/ical-generator.php?eventid=<?php echo $postID; ?>">Download iCal</a></li>
                  <?php
                      $location_string=urlencode($location." ".$adress." ".$postal." ".$locality." ".$country)
                   ?>
                 </li>

                   <li>
                <a href="<?php echo "http://www.google.com/calendar/render?action=TEMPLATE&text=" . urlencode($title)
                . "&dates=". $google_start_date ."/". $google_end_date . "&details=" . wp_strip_all_tags($content) .
                "&location=".  $location_string . "&sf=true&output=xml" ;?>"
                target="_blank" rel="nofollow">Add to Google calendar</a></li>
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
                  if (time()>$deadline){
                    add_filter( 'the_content', 'remove_shortcode_from_index' );
                  }
                  the_content();
                  if (time()>$deadline){
                  remove_filter('the_content', 'remove_shortcode_from_index');
                  }
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
