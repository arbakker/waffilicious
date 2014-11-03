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
    'supports'      =>   $supports
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
    $price = get_post_meta($post->ID, 'price', true);
    $members = get_post_meta($post->ID, 'members', true);
    // if there is previously saved value then retrieve it, else set it to the current time
    $event_start_date = ! empty( $event_start_date ) ? $event_start_date : time();
    //we assume that if the end date is not present, event ends on the same day
    $event_end_date = ! empty( $event_end_date ) ? $event_end_date : $event_start_date;
    // if there is previously saved value then retrieve it, else set it to the event date
    $event_deadline = ! empty( $event_deadline ) ? $event_deadline : $event_start_date;
    $costs = ! empty( $costs ) ? $costs : "0";
    ?>

<label for="start-date"><?php _e( 'Event Start Date:', 'uep' ); ?></label>
        <input class="date required widefat uep-event-date-input" id="start-date" type="text" name="uep-event-start-date" placeholder="" value="<?php echo date( 'F d, Y', $event_start_date ); ?>" />

<label for="end-date"><?php _e( 'Event End Date:', 'uep' ); ?></label>
        <input class="date required  widefat uep-event-date-input" id="end-date" type="text" name="uep-event-end-date" placeholder="" value="<?php echo date( 'F d, Y', $event_end_date ); ?>" />

<label for="deadline"><?php _e( 'Event Registration Deadline:', 'uep' ); ?></label>
        <input class="date  widefat uep-event-date-input" id="deadline" type="text" name="uep-event-deadline" placeholder="" value="<?php echo date( 'F d, Y',   $event_deadline ); ?>" />


<label for="venue"><?php _e( 'Event Venue:', 'uep' ); ?></label>
        <input class="widefat required" id="venue" type="text" name="uep-event-venue" placeholder="eg. Times Square" value="<?php echo $event_venue; ?>" />

<label for="price">Price</label>
<input name="price"type="text" id="price" class="widefat required" value="<?php echo $price; ?>" />
<!--<label for="members">Members</label>
<input name="members"type="text" id="price" class="widefat" value="<?php echo $members; ?>" /> -->
    <?php
    }

add_action( 'admin_enqueue_scripts', 'uep_admin_script_style' );

function uep_admin_script_style( $hook){
  if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
//  wp_enqueue_script('my_validate', 'path/to/jquery.validate.min.js', array('jquery'));
  wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/vendor/jquery-ui.js', array('jquery'));
  wp_enqueue_style('jquery-ui.min', get_template_directory_uri() . '/vendor/jquery-ui.css');
  wp_enqueue_script('chosen.jquery', get_template_directory_uri() . '/vendor/chosen.jquery.min.js', array('jquery'));
  wp_enqueue_style('chosen', get_template_directory_uri() . '/vendor/chosen.css');
  wp_enqueue_style('jquery-ui.theme', get_template_directory_uri() . '/vendor/jquery-ui.theme.css');
  wp_enqueue_style('jquery-ui.structure', get_template_directory_uri() . '/vendor/jquery-ui.structure.css');
  wp_enqueue_script( 'admin.js', get_template_directory_uri() . '/js/admin.js' ,false, false, true );
}}

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

    // checking for the values and performing necessary actions
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
      //  echo '<h1>TRUE</h1>';
        update_post_meta( $post_id, 'event-venue', sanitize_text_field( $_POST['uep-event-venue'] ) );
    }
    if ( isset( $_POST['price'] ) ) {
      //  echo '<h1>TRUE</h1>';
        update_post_meta( $post_id, 'price', sanitize_text_field( $_POST['price'] ) );
    }
    // Remove members field from admin view. Perhaps add functionality to remove members from event later.
    //if ( isset( $_POST['members'] ) ) {
      //  echo '<h1>TRUE</h1>';
      //  update_post_meta( $post_id, 'members', sanitize_text_field( $_POST['members'] ) );
    //}
}
add_action( 'save_post', 'uep_save_event_info' );

function is_user_registered ($user_id, $post_id) {
  $members = get_post_meta( $post_id, 'members', true );
  $user_id="{$user_id}";
  $pos = strpos($members,$user_id);
  if($pos === false) {
    return "false";
  }
else{
    return "true";
}
}

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
  $post_id = $_POST['id'];
  $members = $_POST['members'];
  $registered_members = get_post_meta($post_id, 'members', true);

  $arr=explode(',', $members);

  foreach ($arr as &$member) {
      $registered =is_user_registered ($member, $post_id);
      if( $registered=='false' ){
        $registered_members=waf_add_member($member, $registered_members);
      }
  }

  $registered_members=waf_remove_empty($registered_members);

  $result=update_post_meta($post_id,'members',$registered_members);

  if ($result===true){
    $return = array(
    'result' => $result,
    'registered_members' => $registered_members,
     );
    wp_send_json_success($return);
  }
  else{
    $return = array(
    'registered_members' => $registered_members,
     );
    wp_send_json_error($return);
  }


}


add_action('wp_ajax_addmember', 'addmember_ajax');
function addmember_ajax() {
    $post_id = $_POST['id'];
    $members = get_post_meta($post_id, 'members', true);
    $member = intval($_POST['member']);
    $registered =is_user_registered ($member, $post_id);
    $details = sanitize_text_field($_POST['details']);

    $details_meta = get_post_meta( $post_id, 'details', true );

    if (is_null($details_meta)){
      $details_meta=array();
    }
    $details_meta["$member"]=$details;


    $result2=update_post_meta($post_id,'details',$details_meta);

    $message="";

    if( $registered=='false' ){
      $members=waf_add_member($member, $members);
      }
    $members=waf_remove_empty($members);
    $message = "members=".$members."&postid=".$post_id;
    $result=update_post_meta($post_id,'members',$members);

    if ($result===true){
      $return = array(
        'sanitized_details' => sanitize_text_field($_POST['details']),
        'post_details'=>$_POST['details'],
        'details_meta' => $details_meta[$member],
        'result2' => $result2,
        'result' => $result,
			'message'	=> $message,
      'details' => $details_meta
	     );
      wp_send_json_success($return);
    }
    else{
      $return = array(
      'message'	=> $message,
      'members' => $members,

       );
      wp_send_json_error($return);
    }
}

add_action('wp_ajax_removemember', 'removemember_ajax');

function removemember_ajax() {
    $post_id = $_POST['id'];
    $members = get_post_meta($post_id, 'members', true);
    $member = intval($_POST['member']);

    $registered =is_user_registered ($member, $post_id) ;
    $message="";

    $members=waf_remove_member($member, $members);
    $members=waf_remove_empty($members);

    $result=update_post_meta($post_id,'members',$members);

    if ($result===true){
      $return = array(
      'message'	=> $message,
       );
      wp_send_json_success($return);
    }
    else{
      $return = array(
      'message'	=> $message,
      'members' => $members,
       );
      wp_send_json_error($return);
    }
}


function waf_remove_member($member, $members){
  $arr=explode(',', $members);
  $result="";
  for($i=0;$i<count($arr);$i++) {
    if ($arr[$i]!=strval($member)){
      if ($result==''){
        $result=$arr[$i];
      }
      else{
        $result= $result.",".$arr[$i];
      }
    }
  }

  $members = $result;
  return $members;
}

function waf_remove_empty($members){
  $arr=explode(',', $members);

  $result="";

  foreach ($arr as &$member){

    if ( empty($member)==false ){
      if ($result==""){
        $result=$member;
      }else{
      $result= $result.",".$member;
      }
    }
  }
  return $result;
}

function waf_add_member($member, $members){
  if ($members==''){
    $members=$member;
  }else{
    $members= $members.",".$member;
  }
  return $members;
}

function waf_get_details($member,$post_id){
  $details_meta = get_post_meta( $post_id, 'details', true );
  return $details_meta["$member"];
}

function waf_remove_details($member, $post_id){
  //unset($array['key-here']);
  $details_meta = get_post_meta( $post_id, 'details', true );
  unset($details_meta["$member"]);
  update_post_meta($post_id,'details',$details_meta);
}


function add_registered_members_metabox() {
    add_meta_box(
        'registered-members-event-metabox',
        __( 'Registered members', 'regmem' ),
        'render_registered_members',
        'event',
        'normal',
        'core'
    );
  }
add_action( 'add_meta_boxes', 'add_registered_members_metabox' );

function render_registered_members($post ) {

    // get previously saved meta values (if any)
    $members = get_post_meta($post->ID, 'members', true);
    $arr=explode(',', $members);

    echo '<select id="select-members" data-placeholder="Choose a name..." style="width:350px;" multiple class="chosen">';

    $blogusers = get_users( );
// Array of WP_User objects.
    foreach ( $blogusers as $user ) {
	     echo '<option value="'.$user->ID.'">'.$user->display_name .'</option>';
    }
    echo '</select>';

    echo "<button style='height: 2.2em;width: 4em;' type='button' id='add-members' postid=".get_the_ID().">Add</button>";

    echo "<table id='registered-members' style='border-collapse: collapse;margin-top:0.5em;'><thead>";
    echo "<tr>
    <th style='border: 1px solid #999;padding: 0.5rem;'>User</th>
    <th style='border: 1px solid #999;padding: 0.5rem;' >Email</th>
    <th style='border: 1px solid #999;padding: 0.5rem;' >Details</th>
    <th style='border: 1px solid #999;padding: 0.5rem;' >Remove</th>
    </tr></thead><tbody>";
    if (!empty($members)){
    for($i=0;$i<count($arr);$i++) {
      $user_id=intval($arr[$i]);
      $user = get_userdata( $user_id );


    echo   "<tr class='user user-".$user_id."' id='".$user_id."'>
    <td style='border: 1px solid #999;padding: 0.5rem;''>".  $user->user_login. "</td>
    <td style='border: 1px solid #999;padding: 0.5rem;''>".  $user->user_email ."</td>
    <td style='border: 1px solid #999;padding: 0.5rem;''>". get_post_meta( $post->ID, 'details', true )["$user_id"]."</td>
    <td style='border: 1px solid #999;padding: 0.5rem;''>". "<button id='unregister-".$user_id."' style='height: 2.2em;width: 4em;' type='button'>X</button>"."</td>
    </tr>";
  }}
    echo "</tbody></table>";
}


function build_taxonomies() {
register_taxonomy( 'event_categories', 'event', array( 'hierarchical' => true, 'label' => 'Event Categories', 'query_var' => true, 'rewrite' => true ) );
}

add_action( 'init', 'build_taxonomies', 0 );


function get_event_date_string($start_date,$start_day,$start_month, $end_date,$end_day,$end_month){
  if ($start_date!=$end_date){
    if ($start_month===$end_month){
      return $start_day."-".$end_day." ".$end_month;
    }else{
      return $fulldate=$start_day." ".$start_month."-".$end_day." ".$end_month;
    }
  }else{
    return $fulldate=$start_day." ".$start_month;
  }
}




?>
