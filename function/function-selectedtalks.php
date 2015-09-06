<?php

$st_labels = array(
    'name' => _x('Selected Talks', 'post type general name'),
    'singular_name' => _x('Selected Talk', 'post type singular name'),
    'add_new' => _x('Add New', 'selected-talk'),
    'add_new_item' => __("Add New Selected Talk"),
    'edit_item' => __("Edit Selected Talk"),
    'new_item' => __("New Selected Talk"),
    'view_item' => __("View Selected Talk"),
    'search_items' => __("Search Selected Talk"),
    'not_found' =>  __('No selected talks found'),
    'not_found_in_trash' => __('No selected talks found in Trash'),
    'parent_item_colon' => ''

);
$st_args = array(
    'labels' => $st_labels,
    'public' => true,
    'publicly_queryable' => false,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'rewrite' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'selected-talks'),
    'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
    'menu_icon' => ''//16x16 png if you want an icon
);
register_post_type('selected-talks', $st_args);
function my_taxonomies_st() {
  $labels = array(
    'name'              => _x( 'Selected Talk Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Selected Talk Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Selected Talk Categories' ),
    'all_items'         => __( 'All Selected Talk Categories' ),
    'parent_item'       => __( 'Parent Selected Talk Category' ),
    'parent_item_colon' => __( 'Parent Selected Talk Category:' ),
    'edit_item'         => __( 'Edit Selected Talk Category' ),
    'update_item'       => __( 'Update Selected Talk Category' ),
    'add_new_item'      => __( 'Add New Selected Talk Category' ),
    'new_item_name'     => __( 'New Selected Talk Category' ),
    'menu_name'         => __( 'Selected Talk Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'st_category', 'selected-talk', $args );
}

function waf_add_st_info_metabox() {
    add_meta_box(
        'waf-st-info-metabox',
        'Selected Talk Info' ,
        'waf_render_st_info_metabox',
        'selected-talks',
        'side',
        'core'
    );
}
add_action( 'add_meta_boxes', 'waf_add_st_info_metabox' );

function waf_render_st_info_metabox( $post ) {
    // generate a nonce field
    wp_nonce_field( basename( __FILE__ ), 'waf-st-info-nonce' );
    // get previously saved meta values (if any)
    $source = get_post_meta( $post->ID, 'st-source', true );
    $submitter = get_post_meta( $post->ID, 'st-submitter', true );
    $blogusers = get_users( );
    echo "<label for='st-source'><?php _e( 'Source:', 'uep' ); ?>Source</label>";
    echo '<select id="st-source" name="st-source"  data-placeholder="Choose a name..." style="width:350px;"  class="postform chosen">';

    foreach ( $blogusers as $user ) {

      if ($user->ID==$source){
        echo '<option selected value="'.$user->ID.'" >'.$user->display_name .'</option>';
      }else{
      echo '<option value="'.$user->ID.'" >'.$user->display_name .'</option>';
    }
    }
    echo '</select>';
    echo "<label for='st-submitter'><?php _e( 'Submitter:', 'uep' ); ?>Submitter</label>";
    echo '<select id="st-submitter" name="st-submitter" data-placeholder="Choose a name..." style="width:350px;" value="'.$submitter.'" class="postform chosen">';
    foreach ( $blogusers as $user ) {
      $details=waf_get_details($user->ID,$post->ID);
      if ($user->ID==$submitter){
        echo '<option selected value="'.$user->ID.'" >'.$user->display_name .'</option>';
      }else{
      echo '<option value="'.$user->ID.'" >'.$user->display_name .'</option>';
    }
    }
    echo '</select>';
  }


function waf_save_st_info( $post_id ) {
    // checking if the post being saved is an 'event',
    // if not, then return
    if ( 'selected-talks' != $_POST['post_type'] ) {
        return;
    }

    // checking for the 'save' status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['waf-st-info-nonce'] ) && ( wp_verify_nonce( $_POST['waf-st-info-nonce'], basename( __FILE__ ) ) ) ) ? true : false;

    // exit depending on the save status or if the nonce is not valid
    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }
    if ( isset( $_POST['st-submitter'] ) ) {
        update_post_meta( $post_id, 'st-submitter', sanitize_text_field($_POST['st-submitter'] ) );
    }
    if ( isset( $_POST['st-source'] ) ) {
        update_post_meta( $post_id, 'st-source', sanitize_text_field( $_POST['st-source'] ) );
    }

}
add_action( 'save_post', 'waf_save_st_info' );

add_action( 'init', 'my_taxonomies_st', 0 );

?>
