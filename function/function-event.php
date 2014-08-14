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
    'menu_icon'     =>   IMAGES . 'event.svg',
    'has_archive'   =>   true,
    'rewrite'       =>   true,
    'supports'      =>   $supports
);

register_post_type( 'event', $args );

function uep_custom_post_type() {
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
        'menu_icon'     =>   IMAGES . 'event.svg',
        'has_archive'   =>   true,
        'rewrite'       =>   true,
        'supports'      =>   $supports
    );

    register_post_type( 'event', $args );
}
add_action( 'init', 'uep_custom_post_type' );

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
    $event_venue = get_post_meta( $post->ID, 'event-venue', true );
    $price = get_post_meta($post->ID, 'price', true);
    $members = get_post_meta($post->ID, 'members', true);
    // if there is previously saved value then retrieve it, else set it to the current time
    $event_start_date = ! empty( $event_start_date ) ? $event_start_date : time();
    //we assume that if the end date is not present, event ends on the same day
    $event_end_date = ! empty( $event_end_date ) ? $event_end_date : $event_start_date;
    $costs = ! empty( $costs ) ? $costs : "0";



    ?>

<label for="start-date"><?php _e( 'Event Start Date:', 'uep' ); ?></label>
        <input class="date required widefat uep-event-date-input" id="start-date" type="text" name="uep-event-start-date" placeholder="Format: February 18, 2014" value="<?php echo date( 'F d, Y', $event_start_date ); ?>" />

<label for="end-date"><?php _e( 'Event End Date:', 'uep' ); ?></label>
        <input class="date required  widefat uep-event-date-input" id="end-date" type="text" name="uep-event-end-date" placeholder="Format: February 18, 2014" value="<?php echo date( 'F d, Y', $event_end_date ); ?>" />

<label for="venue"><?php _e( 'Event Venue:', 'uep' ); ?></label>
        <input class="widefat required" id="venue" type="text" name="uep-event-venue" placeholder="eg. Times Square" value="<?php echo $event_venue; ?>" />

<label for="price">Price</label>
<input name="price"type="text" id="price" class="widefat required" value="<?php echo $price; ?>" />
<label for="members">Members</label>
<input name="members"type="text" id="price" class="widefat" value="<?php echo $members; ?>" />
    <?php
    }

add_action( 'admin_enqueue_scripts', 'uep_admin_script_style' );

function uep_admin_script_style( $hook){
  if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
//  wp_enqueue_script('my_validate', 'path/to/jquery.validate.min.js', array('jquery'));
  wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/vendor/jquery-ui.js', array('jquery'));
  wp_enqueue_style('jquery-ui.min', get_template_directory_uri() . '/vendor/jquery-ui.css');
  wp_enqueue_style('jquery-ui.theme', get_template_directory_uri() . '/vendor/jquery-ui.theme.css');
  wp_enqueue_style('jquery-ui.structure', get_template_directory_uri() . '/vendor/jquery-ui.structure.css');
  wp_enqueue_script( 'admin.js', get_template_directory_uri() . '/js/admin.js' ,false, false, true );
}}
add_action( 'save_post', 'uep_save_event_info' );
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
        update_post_meta( $post_id, 'event-start-date', strtotime( $_POST['uep-event-start-date'] ) );
    }

    if ( isset( $_POST['uep-event-end-date'] ) ) {
        update_post_meta( $post_id, 'event-end-date', strtotime( $_POST['uep-event-end-date'] ) );
    }

    if ( isset( $_POST['uep-event-venue'] ) ) {
      //  echo '<h1>TRUE</h1>';
        update_post_meta( $post_id, 'event-venue', sanitize_text_field( $_POST['uep-event-venue'] ) );
    }
    if ( isset( $_POST['price'] ) ) {
      //  echo '<h1>TRUE</h1>';
        update_post_meta( $post_id, 'price', sanitize_text_field( $_POST['price'] ) );
    }
    if ( isset( $_POST['members'] ) ) {
      //  echo '<h1>TRUE</h1>';
        update_post_meta( $post_id, 'members', sanitize_text_field( $_POST['members'] ) );
    }
}

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
$html = '<script type="text/javascript">';
$html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
$html .= '</script>';
echo $html;
}


add_action('wp_ajax_newmember', 'newmember_ajax');
function newmember_ajax() {
    $post_id = $_POST['id'];

    //Get current bid
    $members = get_post_meta($post_id, 'members', true);

    //Increase the bid, for example the amount here is 100€
    $member = $_POST['member'];


    $registered =is_user_registered ($member, $post_id) ;
    echo "<h1>Registered -".$registered."</h1>";
    if ($registered == "true"){
      $members= $members;
    }
      else{
      if ($members==''){
        $members=$member;
      }else{
        $members= $members.",".$member;
      }

    }




    //Update the database with the increased bid value
    update_post_meta($post_id,'members',$members);
    $response_array['status'] = 'success';
    header('Content-type: application/json');
    echo json_encode($response_array);



    // In case you need to update another meta for the user, you
    // can access the user ID with the get_current_user_id() function

    // Finally sending back the updated bid so the javascript can display it

}




?>
