<?php

$labels = array(
    'name'                  =>   __( 'Events', 'uep' ),
    'singular_name'         =>   __( 'Event', 'uep' ),
    'add_new_item'          =>   __( 'Add New Event', 'uep' ),
    'all_items'             =>   __( 'All Events', 'uep' ),
    'edit_item'             =>   __( 'Edit Event', 'uep' ),
    'new_item'              =>   __( 'New Event', 'uep' ),
    'view_item'             =>   __( 'View Event', 'uep' ),
    'not_found'             =>   __( 'No Events Found', 'uep' ),
    'not_found_in_trash'    =>   __( 'No Events Found in Trash', 'uep' )
);

$supports = array(
    'title',
    'editor',
    'excerpt',
    'thumbnail'
);



$args = array(
    'label'         =>   __( 'Events', 'uep' ),
    'labels'        =>   $labels,
    'description'   =>   __( 'A list of upcoming events', 'uep' ),
    'public'        =>   true,
    'show_in_menu'  =>   true,
    'menu_icon'     =>   '',
    'has_archive'   =>   true,
    'rewrite'       =>   true,
    'supports'      =>   $supports,
    );

register_post_type( 'event', $args );

// Display font awesome icon in admin panel
function event_css() {
   echo "<style type='text/css' media='screen'>
       #adminmenu .menu-icon-event div.wp-menu-image:before {
            font-family:  FontAwesome !important;
            content: '\\f073'; // this is where you enter the fontaweseom font code
        }
        #adminmenu .menu-icon-products div.wp-menu-image:before {
             font-family:  FontAwesome !important;
             content: '\\f07a'; // this is where you enter the fontaweseom font code
         }
         #adminmenu .menu-icon-gallery div.wp-menu-image:before {
              font-family:  FontAwesome !important;
              content: '\\f083'; // this is where you enter the fontaweseom font code
          }
          #adminmenu .menu-icon-selected-talks div.wp-menu-image:before {
               font-family:  FontAwesome !important;
               content: '\\f0e5'; // this is where you enter the fontaweseom font code
           }


     </style>";
}
add_action('admin_head', 'event_css');

function uep_add_event_info_metabox() {
    add_meta_box(
        'uep-event-info-metabox',
        __( 'Event Info', 'uep' ),
        'uep_render_event_info_metabox',
        'event',
        'side',
        'core'
    );
}
add_action( 'add_meta_boxes', 'uep_add_event_info_metabox' );

function uep_render_event_info_metabox( $post ) {
    // generate a nonce field
    wp_nonce_field( basename( __FILE__ ), 'uep-event-info-nonce' );
    // get previously saved meta values (if any)
    $event_start_date = get_post_meta( $post->ID, 'event-start-date', true );
    $event_end_date = get_post_meta( $post->ID, 'event-end-date', true );
    $event_deadline = get_post_meta( $post->ID, 'event-deadline', true );
    $event_venue = get_post_meta( $post->ID, 'event-venue', true );
    //address
    $event_address = get_post_meta( $post->ID, 'event-address', true );
    //postal code
    $event_postal = get_post_meta( $post->ID, 'event-postal', true );
    // locality
    $event_locality = get_post_meta( $post->ID, 'event-locality', true );
    $event_country = get_post_meta( $post->ID, 'event-country', true );

    $event_organizer = get_post_meta( $post->ID, 'event-organizer', true );
    $event_url = get_post_meta( $post->ID, 'event-url', true );

    $price = get_post_meta($post->ID, 'price', true);
    $members = get_post_meta($post->ID, 'members', true);
    $guest_players = get_post_meta($post->ID, 'guest_players', true);
    // if there is previously saved value then retrieve it, else set it to the current time
    date_default_timezone_set('Europe/Amsterdam');
    $heden=  time();
    $event_country = ! empty( $event_country ) ? $event_country : "the Netherlands";
    $event_start_date = ! empty( $event_start_date ) ? $event_start_date : $heden;
    //we assume that if the end date is not present, event ends on the same day
    $event_end_date = ! empty( $event_end_date ) ? $event_end_date : $event_start_date;
    // if there is previously saved value then retrieve it, else set it to the event date
    $event_deadline = ! empty( $event_deadline ) ? $event_deadline : $event_start_date;
    $costs = ! empty( $costs ) ? $costs : "0";

    ?>

<label for="start-date"><?php _e( 'Start Date:', 'uep' ); ?></label>
        <input class="date required widefat uep-event-date-input" id="start-date" type="text" name="uep-event-start-date" placeholder="" value="<?php echo date( 'd F Y  H:i', $event_start_date ); ?>" />

<label for="end-date"><?php _e( 'End Date:', 'uep' ); ?></label>
        <input class="date required  widefat uep-event-date-input" id="end-date" type="text" name="uep-event-end-date" placeholder="" value="<?php echo date( 'd F Y  H:i', $event_end_date ); ?>" />

<label for="deadline"><?php _e( 'Registration Deadline:', 'uep' ); ?></label>
        <input class="date  widefat uep-event-date-input" id="deadline" type="text" name="uep-event-deadline" placeholder="" value="<?php echo date( 'd F Y',   $event_deadline ); ?>" />

<label for="venue"><?php _e( 'Venue:', 'uep' ); ?></label>
        <input class="widefat" id="venue" type="text" name="uep-event-venue" placeholder="de Bongerd" value="<?php echo $event_venue; ?>" />

<label for="address"><?php _e( 'Address:', 'uep' ); ?></label>
        <input class="widefat " id="address" type="text" name="uep-event-address" placeholder="Bornsesteeg 2" value="<?php echo $event_address; ?>" />
<label for="postal"><?php _e( 'Postal code:', 'uep' ); ?></label>
        <input class="widefat " id="postal" type="text" name="uep-event-postal" placeholder="6708 PE" value="<?php echo $event_postal; ?>" />
<label for="locality"><?php _e( 'Locality:', 'uep' ); ?></label>
        <input class="widefat " id="locality" type="text" name="uep-event-locality" placeholder="Wageningen" value="<?php echo $event_locality; ?>" />
<label for="country"><?php _e( 'Country:', 'uep' ); ?></label>
        <input class="widefat " id="country" type="text" name="uep-event-country" placeholder="the Netherlands" value="<?php echo $event_country; ?>" />
<label for="organizer"><?php _e( 'Organizer:', 'uep' ); ?></label>
        <input class="widefat " id="organizer" type="text" name="uep-event-organizer" placeholder="WAF" value="<?php echo $event_organizer; ?>" />
<label for="event-url"><?php _e( 'Event URL:', 'uep' ); ?></label>
        <input class="widefat" id="event-url" type="text" name="uep-event-url" placeholder="" value="<?php echo $event_url; ?>" />

<label for="price">Price</label>
<input name="price"type="text" id="price" class="widefat required" value="<?php echo $price; ?>" />

    <?php
    }


function uep_save_event_info( $post_id ) {
    // checking if the post being saved is an 'event',
    // if not, then return
    if ( 'event' != $_POST['post_type'] ) {
        return;
    }

    // checking for the 'save' status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['uep-event-info-nonce'] ) && ( wp_verify_nonce( $_POST['uep-event-info-nonce'], basename( __FILE__ ) ) ) ) ? true : false;

    // exit depending on the save status or if the nonce is not valid
    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }
    if ( isset( $_POST['uep-event-start-date'] ) ) {
        $time = new DateTime($_POST['uep-event-start-date']);
        update_post_meta( $post_id, 'event-start-date', strtotime( $_POST['uep-event-start-date'] ) );
        $sortdate=  date( 'Ymd', strtotime( $_POST['uep-event-start-date'] ) );
        update_post_meta( $post_id, 'event-sort-date', $sortdate);
    }
    if ( isset( $_POST['uep-event-end-date'] ) ) {
        update_post_meta( $post_id, 'event-end-date', strtotime( $_POST['uep-event-end-date'] ) );
    }
    if ( isset( $_POST['uep-event-deadline'] ) ) {
        if ($_POST['uep-event-deadline']){
          update_post_meta( $post_id, 'event-deadline', strtotime( $_POST['uep-event-deadline'] ) );
        }else{
          update_post_meta( $post_id, 'event-deadline', strtotime( $_POST['uep-event-start-date'] ) );
        }
    }
    if ( isset( $_POST['uep-event-venue'] ) ) {
        update_post_meta( $post_id, 'event-venue', sanitize_text_field( $_POST['uep-event-venue'] ) );
    }
    if ( isset( $_POST['uep-event-address'] ) ) {
        update_post_meta( $post_id, 'event-address', sanitize_text_field( $_POST['uep-event-address'] ) );
    }
    if ( isset( $_POST['uep-event-postal'] ) ) {
        update_post_meta( $post_id, 'event-postal', sanitize_text_field( $_POST['uep-event-postal'] ) );
    }
    if ( isset( $_POST['uep-event-locality'] ) ) {
        update_post_meta( $post_id, 'event-locality', sanitize_text_field( $_POST['uep-event-locality'] ) );
    }
    if ( isset( $_POST['uep-event-country'] ) ) {
        update_post_meta( $post_id, 'event-country', sanitize_text_field( $_POST['uep-event-country'] ) );
    }
    if ( isset( $_POST['uep-event-organizer'] ) ) {
      if (sanitize_text_field( $_POST['uep-event-organizer'] )){
        update_post_meta( $post_id, 'event-organizer', sanitize_text_field( $_POST['uep-event-organizer'] ) );
      }else{
        update_post_meta( $post_id, 'event-organizer', "WAF" );
      }
    }
    if ( isset( $_POST['uep-event-url'] ) ) {

    if ( $_POST['uep-event-url']===''){
      $permalink=get_permalink($post_id);
      update_post_meta( $post_id, 'event-url', $permalink );
    }
    elseif (startsWith(sanitize_text_field( $_POST['uep-event-url'] ),"http://")||startsWith(sanitize_text_field( $_POST['uep-event-url'] ),"https://")){
    update_post_meta( $post_id, 'event-url', sanitize_text_field( $_POST['uep-event-url'] ) );
    }else{
      update_post_meta( $post_id, 'event-url', 'http://'.sanitize_text_field( $_POST['uep-event-url'] ) );
    }

    }
    if ( isset( $_POST['price'] ) ) {
        update_post_meta( $post_id, 'price', sanitize_text_field( $_POST['price'] ) );
    }
}
add_action( 'save_post', 'uep_save_event_info' );

add_action('wp_head','my_ajaxurl');
function my_ajaxurl() {
global $current_user;
get_currentuserinfo();
$html = '<script type="text/javascript">';
$html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"'.';';
$html .= 'var userid = "' . $current_user->ID . '"'.';';
$html .= 'var username = "' . $current_user->display_name . '"'.';';
$html .= 'var useremail = "' . $current_user->user_email . '"'.';';
$html .= 'var siteurl = "' . site_url() . '"'.';';
$html .= '</script>';
echo $html;
}

add_action('wp_ajax_addmembers', 'addmembers_ajax');
function addmembers_ajax() {
  $nonce = $_POST['addmembersNonce'];
  if ( ! wp_verify_nonce( $nonce, 'addmembers-nonce' )){
    $return = array(
      'message' => "Could not add member(s), nonce could not be verified.",
    );
    wp_send_json_error($return);
    exit();
  }
  // Get ajax request post parameters
  $post_id = $_POST['id'];
  $members = $_POST['members'];
  $registered_members = get_post_meta($post_id, 'members', true);


  if (current_user_can('edit_post', $post_id )){
    $arr=explode(',', $members);

    foreach ($arr as $member) {
        $details="";
        $registered_members_new=waf_add_member($member,$details, $registered_members);
    }

    $result=update_post_meta($post_id,'members',$registered_members_new);
    $message="Succesfully added members to event.";
  }else{
    $message="You do not have rights to add members to this event";
    $result=false;
  }

  if ($result===true){
    $return = array(
    'message' => $message,
     );
    wp_send_json_success($return);
  }
  else{
    if ($registered_members_new==$registered_members){
      $message="Could not add member, member already registered.";
    }else{
      $message="Server errror: could not add members to event.";
    }
    $return = array(
    'message' => $message,
     );
    wp_send_json_error($return);
  }
}

function is_user_registered($userid,$postid){
  $members = get_post_meta($postid, 'members', true);
  return array_key_exists($userid,$members);
}

add_action('wp_ajax_addmember', 'addmember_ajax');
function addmember_ajax() {
    // Check nonce
    $nonce = $_POST['addmemberNonce'];

    if ( ! wp_verify_nonce( $nonce, 'addmember-nonce' )){
      $return = array(
        'message'	=> "Could not add member, nonce could not be verified.",
      );
      wp_send_json_error($return);
      exit();
    }

    // Check current user
    $current_user = wp_get_current_user();
    $roles=$user->roles;
    $userid=intval($current_user->ID);
    // Get ajax request post parameters
    $post_id = $_POST['id'];
    $members = get_post_meta($post_id, 'members', true);
    $member = intval($_POST['member']);
    $details = sanitize_text_field($_POST['details']);

    // Check if member edits own userdetails or has rights to edit post
    $deadline=get_post_field( 'event-deadline', $post_id );
    $daystodeadline=intval(($deadline - time())/(3600*24));
    if (($member==$userid and $daystodeadline>-1) or current_user_can('edit_post', $post_id ) ){

      $members=waf_add_member($member,$details, $members);
      $result=update_post_meta($post_id,'members',$members);
      $result_check=get_post_meta($post_id, 'members', true);
      $message = "You have succesfully registered user ". strval($member)." for event ".strval($post_id).".";
    }else{
      $result=false;
      $message="You are not allowed to create, update or delete registrations for other users than yourself for this event.";
    }

    if ($result===true){
      $return = array(
        'result' => $result,
			  'message'	=> $message,
        'nonce' => $nonce,
        'details' => $details,
        'check'=> $result_check,
        'postid'=>strval($post_id),
        'members'=>$members,

	     );
      wp_send_json_success($return);
    }
    else{
      $return = array(
      'result'	=> $result,
      'message' => $message,
      'userid' => $userid,
      'member' => $member,
      );
      wp_send_json_error($return);
    }
}

add_action('wp_ajax_removemember', 'removemember_ajax');

function removemember_ajax() {
    // Check nonce
    $nonce = $_POST['removememberNonce'];

    if ( ! (wp_verify_nonce( $nonce, 'removemember-nonce' ) or wp_verify_nonce( $nonce, 'removemember2-nonce' ) ) ){
      $return = array(
        'message'	=> "Could not remove member, nonce could not be verified.",
      );
      wp_send_json_error($return);
      exit();
    }
    // Check current user
    $current_user = wp_get_current_user();
    $roles=$user->roles;
    $userid=intval($current_user->ID);

    // Retrieve post parameters ajax request
    $post_id = $_POST['id'];
    $members = get_post_meta($post_id, 'members', true);
    $member = intval($_POST['member']);

    // Check if member edits own userdetails or has rights to edit post
    if ($member==$userid or current_user_can('edit_post', $post_id ) ){

      $members=waf_remove_member($member, $members);

      $result=update_post_meta($post_id,'members',$members);
    }else{
      $message="You are not allowed to create, update or delete registrations for other users than yourself for this event.";
      $result=false;
    }
    if ($result===true){
      $return = array(
      'message'	=> $message,
       );
      wp_send_json_success($return);
    }
    else{
      $return = array(
      'message'	=> $message,
       );
      wp_send_json_error($return);
    }
}


add_action('wp_ajax_addguest', 'addguest_ajax');
function addguest_ajax() {
  // Check nonce
  $nonce = $_POST['addguestNonce'];
  if ( ! wp_verify_nonce( $nonce, 'addguest-nonce' )){
    $return = array(
      'message'	=> "Could not add guest player, nonce could not be verified.",
    );
    wp_send_json_error($return);
    exit();
  }
  // Get ajax request post parameters
  $post_id = intval($_POST['id']);
  $guest_player = sanitize_text_field($_POST['guest_player']);
  $guest_email = sanitize_text_field($_POST['guest_email']);
  $guest_details = sanitize_text_field($_POST['guest_details']);
  $guest_veggie = sanitize_text_field($_POST['guest_veggie']);
  $guest_players = get_post_meta($post_id, 'guest_players', true);
  // Check if member edits own userdetails or has rights to edit post
  if (current_user_can('edit_post', $post_id or ! empty($guest_player) ) ){
    // $a=array();
    // $a["b"]="c";
    // unset($a["b"]);
    if (!$guest_players){
      $guest_players=array();
    }
    $guest_players[$guest_player]=[$guest_email,$guest_details,$guest_veggie];
    $result=update_post_meta($post_id,'guest_players',$guest_players);
  }else{
    if (empty($guest_player)){
      $message="Server error: cannot create guest player without a name.";
    }else{
      $message="You are not allowed to create, update or delete registrations for other users than yourself for this event.";
    }
    $result=false;
  }
  if ($result===true){
    $message = "You have succesfully added a guest player.";
    $return = array(
      'result' => $result,
      'message'	=> $message,
      );
      wp_send_json_success($return);
  }else{
      if (empty($message)){
        $message="Server error: could not add guest player.";
      }
      $return = array(
      'result'	=> $result,
      'message' => $message,
      'guest' => $guest_player,
      );
      wp_send_json_error($return);
    }
  }


  add_action('wp_ajax_removeguest', 'removeguest_ajax');
  function removeguest_ajax() {
    // Check nonce
    $nonce = $_POST['removeguestNonce'];
    if ( ! wp_verify_nonce( $nonce, 'removeguest-nonce' )){
      $return = array(
        'message'	=> "Could not remove guest player, nonce could not be verified.",
      );
      wp_send_json_error($return);
      exit();
    }
    // Get ajax request post parameters
    $post_id = intval($_POST['id']);
    $guest_player = sanitize_text_field($_POST['guest_player']);

    $guest_players = get_post_meta($post_id, 'guest_players', true);
    // Check if member edits own userdetails or has rights to edit post
    if (current_user_can('edit_post', $post_id ) ){
      // $a=array();
      // $a["b"]="c";
      // unset($a["b"]);
      unset($guest_players[$guest_player]);
      $result=update_post_meta($post_id,'guest_players',$guest_players);
      $message = "You have succesfully removed a guest player.";
    }else{
      $result=false;
      $message="You are not allowed to create, update or delete registrations for other users than yourself for this event.";
    }
    if ($result===true){
      $return = array(
        'result' => $result,
        'message'	=> $message,
      );
      wp_send_json_success($return);
    }else{
      $return = array(
        'result'	=> $result,
        'message' => "Server error: could not remove guest player from event.",
        'guest' => $guest_player,
      );
      wp_send_json_error($return);
    }
  }

function waf_remove_member($member, $members){
  unset($members[$member]);
  return $members;
}

function waf_add_member($member,$details, $members){
  if (!$members){
    $members=array();
  }
  $members[$member]=$details;
  return $members;
}

function waf_get_details($member,$post_id){
  $members = get_post_meta($post_id, 'members', true);
  return $members[$member];
}


function add_registered_members_metabox() {
  if  (get_post_status($post->ID )=="publish" ){
    add_meta_box(
        'registered-members-event-metabox',
        __( 'Registered members', 'regmem' ),
        'render_registered_members',
        'event',
        'normal',
        'core'
    );
    add_meta_box(
    'guest-players-event-metabox',
    __( 'Guest players', 'regmem' ),
    'render_guest_players',
    'event',
    'normal',
    'core'
  );
}
  }
add_action( 'add_meta_boxes', 'add_registered_members_metabox' );

function render_registered_members($post ) {
if (current_user_can('edit_post', $post->ID )){
    $members = get_post_meta($post->ID, 'members', true);
    //update_post_meta($post->ID,'members',array());
    echo '<select id="select-members" data-placeholder="Choose a name..." style="width:350px;" multiple class="chosen">';

    $blogusers = get_users( );

    foreach ( $blogusers as $user ) {
      $details=waf_get_details($user->ID,$post->ID);
	    echo '<option value="'.$user->ID.'" >'.$user->display_name .'</option>';
    }
    echo '</select>';

    echo "<button style='height: 2.2em;width: 4em;' type='button' id='add-members' postid=".get_the_ID().">Add</button>";

    echo '<div style="white-space: nowrap;overflow: scroll;">';
    echo "<table id='registered-members' style='border-collapse: collapse;margin-top:0.5em;'><colgroup>
       <col span='1' style='width: 25%;'>
       <col span='1' style='width: 20%;'>
       <col span='1' style='width: 35%;'>
       <col span='1' style='width: 10%;'>
       <col span='1' style='width: 10%;'>
    </colgroup><thead>";
    echo "<tr>
    <th style='border: 1px solid #999;padding: 0.5rem;'>User</th>
    <th style='border: 1px solid #999;padding: 0.5rem;' >Email</th>
    <th style='border: 1px solid #999;padding: 0.5rem;' >Details</th>
    <th style='border: 1px solid #999;padding: 0.5rem;' >Vegetarian</th>
    <th style='border: 1px solid #999;padding: 0.5rem;' >Remove</th>
    </tr></thead><tbody>";

    //update_post_meta($post->ID,'members',array());
    foreach ($members as $key => $value){

      $user_id=intval($key);
      $user = get_userdata( $user_id );

      if (get_the_author_meta( 'veggie', $user_id )=="true"){
       $icon='<i class="fa fa-check"></i>';
      }else{
        $icon='<i class="fa fa-remove"></i>';
      }

    $allergy=get_the_author_meta( 'allergies',   $user_id  );
    if ($allergy){
      if (get_post_meta($post->ID, 'members', true)["$user_id"]){
        $allergy="</br>"."Allergy: ".$allergy;
      }else{
        $allergy="Allergy: ".$allergy;
      }

    }
    echo   "<tr class='user user-".$user_id."' id='".$user_id."'>
    <td style='border: 1px solid #999;padding: 0.5rem;'>".  $user->user_login. "</td>
    <td style='border: 1px solid #999;padding: 0.5rem;'>".  $user->user_email ."</td>
    <td style='border: 1px solid #999;padding: 0.5rem;'>". get_post_meta($post->ID, 'members', true)["$user_id"].$allergy."</td>
    <td style='border: 1px solid #999;padding: 0.5rem;'>". $icon."</td>
    <td style='border: 1px solid #999;padding: 0.5rem;'>". "<button id='unregister-".$user_id."' style='height: 2.2em;width: 4em;' type='button'>X</button>"."</td>
    </tr>";
  }
    echo "</tbody></table></div>";
  }
}

function render_guest_players($post ) {
  if (current_user_can('edit_post', $post->ID )){
    $guest_players = get_post_meta($post->ID, 'guest_players', true);
    ?>
    <div style="white-space: nowrap;overflow: scroll;">
    <table id='guestPlayers' style='border-collapse: collapse;margin-top:0.5em;margin-bottom:2em;'><thead>
    <tr>
      <th style='border: 1px solid #999;padding: 0.5rem;'>Guest player</th>
      <th style='border: 1px solid #999;padding: 0.5rem;' >Email</th>
      <th style='border: 1px solid #999;padding: 0.5rem;' >Details</th>
      <th style='border: 1px solid #999;padding: 0.5rem;' >Veggie</th>
      <th style='border: 1px solid #999;padding: 0.5rem;' >Remove</th>
    </tr></thead>
    <tbody>
    <?php
    foreach ($guest_players as $key => $value){
      if ($value[2]=="true"){
        $icon='<i class="fa fa-check"></i>';
      }else{
        $icon='<i class="fa fa-remove"></i>';
      }

      ?>
      <tr>
        <td style='border: 1px solid #999;padding: 0.5rem;'><?php echo $key; ?></td>
        <td style='border: 1px solid #999;padding: 0.5rem;'><?php echo $value[0]; ?></td>
        <td style='border: 1px solid #999;padding: 0.5rem;'><?php echo $value[1]; ?></td>
        <td style='border: 1px solid #999;padding: 0.5rem;'><?php echo $icon; ?></td>
        <td style='border: 1px solid #999;padding: 0.5rem;'><button class="removeGuest" style='height: 2.2em;width: 4em;' type="button" guest="<?php echo $key;?>">X</button></td>
      </tr>

      <?php
    }
    ?>
    </tbody>
    </table>
    </div>

    <LABEL  style="margin:0.5em;" for="guest_player">Guest player</LABEL>
    <input   style="margin:0.5em;" type="text" id="guest_player"></input></br>
    <LABEL  style="margin:0.5em;" for="guest_email">Email guest</LABEL>
    <input  style="margin:0.5em;" type="email" id="guest_email"></input></br>
    <LABEL  style="margin:0.5em;" for="guest_details">Details guest</LABEL>
    <textarea  style="margin:0.5em;"  id="guest_details"></textarea></br>
    <LABEL  style="margin:0.5em;" for="guest_veggie">Veggie</LABEL>
    <input type="checkbox" id="guest_veggie">
    <button type="button" style="height:2.2em;margin:0.5em;" id="addGuest">Add guest player</button>
    <?php
}
}

function build_taxonomies() {
register_taxonomy( 'event_categories', 'event', array( 'hierarchical' => true, 'label' => 'Event Categories', 'query_var' => true, 'rewrite' => true ) );
}

add_action( 'init', 'build_taxonomies', 0 );

function get_event_date_string($query_start_date,$query_end_date){
  date_default_timezone_set('Europe/Amsterdam');
  $start_time=  date( 'H:i',$query_start_date );
  $end_time=  date( 'H:i',$query_end_date );
  $start_day=  date( 'Y-m-d',$query_start_date );
  $end_day=  date( 'Y-m-d',$query_end_date );

  if ($start_time==$end_time){
    //ALL_DAY
    if($start_day==$end_day){
      //ONE_DAY
      return  date('d M',$query_start_date);
    }else{
      //MULTIPLE_DAYS
      return  date('d M',$query_start_date).' - '.date('d M',$query_end_date);
    }

  }else{
    //SPECIFIC_TIME
    if($start_day==$end_day){
        //ONE_DAY
        return  date('d M',$query_start_date)." ".date( 'H:i',$query_start_date)." - " .date( 'H:i',$query_end_date);
    }else{
        //MULTIPLE_DAYS
        return date('d M',$query_start_date)." ".date( 'H:i',$query_start_date)." - ".date( 'd M',$query_end_date )." ".date( 'H:i',$query_end_date);
    }
  }



}

function waf_alert_string($days, $weeks){
  if ($weeks==0){
    // Case final day
    if ($days==0){
      $message="Hurry with the speed of a laser disc, final day to sign up!";
    }elseif($days==1){
      $message="Scooberdabadoo, second last day to sign up!";
    }elseif($days>1){
      $message= '<strong> '.$days.'</strong> days left to sign up!';
    }
  }elseif ($weeks==1){
    if ($days==0){
      $message='<strong> '.$weeks.'</strong> week left to sign up!';
    }elseif ($days==1){
      $message='<strong> '.$weeks.'</strong> week and <strong>'.$days.'</strong> day left to sign up!';
    }elseif ($days>1){
      $message='<strong> '.$weeks.'</strong> week and <strong>'.$days.'</strong> days left to sign up!';
    }
  }elseif ($weeks>1){
    if ($days==0){
      $message='<strong> '.$weeks.'</strong> weeks left to sign up!';
    }elseif ($days==1){
      $message='<strong> '.$weeks.'</strong> weeks and <strong>'.$days.'</strong> day left to sign up!';
    }elseif ($days>1){
      $message='<strong> '.$weeks.'</strong> weeks and <strong>'.$days.'</strong> days left to sign up!';
    }
  }
  return $message ;
}


?>
