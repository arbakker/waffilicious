<?php
/**
 * waffilicious functions and definitions
 *
 * @package waffilicious
 * @since waffilicious 1.0
 */


if ( ! function_exists( 'waffilicious_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 *
 */
function waffilicious_setup() {
    /**
     * Make theme available for translation
     * Translations can be filed in the /languages/ directory
     * If you're building a theme based on waffilicious, use a find and replace
     * to change 'waffilicious' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'waffilicious', get_template_directory() . '/languages' );
    /**
     * Add default posts and comments RSS feed links to head
     */
    add_theme_support( 'automatic-feed-links' );
    /**
     * Enable support for the Aside Post Format
     */
    $args = array(
      'flex-width'    => true,
      'width'         => 2400,
      'flex-width'    => true,
      'height'        => 320,
      'default-image' => get_template_directory_uri() . '/images/header.jpg',
      'uploads'       => true,
    );
    add_theme_support( 'post-formats', array( 'aside' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-header', $args );
    add_theme_support( 'custom-background', $args );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );

}
endif; // waffilicious_setup

add_action( 'after_setup_theme', 'waffilicious_setup' );

include get_template_directory() .'/function/function-event.php';
include get_template_directory() . '/function/function-product.php';
include get_template_directory() .'/function/function-enqueuescripts.php';
include get_template_directory() . '/function/function-userfield.php';



$args = array(
	'default-color' => 'DCDCDC'
);

add_action( 'init', 'my_add_excerpts_to_pages' );

function my_add_excerpts_to_pages() {
add_post_type_support( 'page', 'excerpt' );
}

add_action('wp_head', 'mbe_wp_head');
function mbe_wp_head(){
    echo '<style>'.PHP_EOL;
    echo 'body{ padding-top: 36px !important; }'.PHP_EOL;
    // Using WordPress default CSS class name.
    echo 'body.logged-in .navbar{ top: 28px !important; }'.PHP_EOL;
    echo '</style>'.PHP_EOL;
}

function check_user_role( $role, $user_id = null ) {
    if ( is_numeric( $user_id ) )
	$user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();

    if ( empty( $user ) )
	return false;

    return in_array( $role, (array) $user->roles );
}


add_action('set_current_user', 'cc_hide_admin_bar');
function cc_hide_admin_bar() {
  if ( check_user_role("subscriber") or check_user_role("participant"))
 {
    show_admin_bar(false);
  }
}




function wpse15850_body_class( $wp_classes, $extra_classes )
{
    // List of the only WP generated classes allowed
    //$whitelist = array( 'home', 'blog', 'archive', 'single', 'category', 'tag', 'error404', 'logged-in', 'admin-bar' );

    // List of the only WP generated classes that are not allowed
    if ( check_user_role( "subscriber" ) or check_user_role("participant" ) ){
    $blacklist = array( 'logged-in' );
    // Filter the body classes
    // Whitelist result: (comment if you want to blacklist classes)
    //$wp_classes = array_intersect( $wp_classes, $whitelist );
    // Blacklist result: (uncomment if you want to blacklist classes)
    $wp_classes = array_diff( $wp_classes, $blacklist );
    // Add the extra classes back untouched
    return array_merge( $wp_classes, (array) $extra_classes );
    }
    else{
        return $wp_classes;
    }
}
add_filter( 'body_class', 'wpse15850_body_class', 10, 2 );




if ( function_exists( 'add_theme_support')){
    add_theme_support( 'post-thumbnails' );
}
add_image_size( 'admin-list-thumb', 80, 80, true); //admin thumbnail


//----------------------------------------------
//----------register and label gallery post type
//----------------------------------------------
$gallery_labels = array(
    'name' => _x('Gallery', 'post type general name'),
    'singular_name' => _x('Gallery', 'post type singular name'),
    'add_new' => _x('Add New', 'gallery'),
    'add_new_item' => __("Add New Gallery"),
    'edit_item' => __("Edit Gallery"),
    'new_item' => __("New Gallery"),
    'view_item' => __("View Gallery"),
    'search_items' => __("Search Gallery"),
    'not_found' =>  __('No galleries found'),
    'not_found_in_trash' => __('No galleries found in Trash'),
    'parent_item_colon' => ''

);
$gallery_args = array(
    'labels' => $gallery_labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'rewrite' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'capability_type' => 'post',
    'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
    'menu_icon' => get_bloginfo('template_directory') . '/images/photo-album.png' //16x16 png if you want an icon
);
register_post_type('gallery', $gallery_args);

//----------------------------------------------
//------------------------create custom taxonomy
//----------------------------------------------
add_action( 'init', 'jss_create_gallery_taxonomies', 0);

function jss_create_gallery_taxonomies(){
    register_taxonomy(
        'phototype', 'gallery',
        array(
            'hierarchical'=> true,
            'label' => 'Photo Types',
            'singular_label' => 'Photo Type',
            'rewrite' => true
        )
    );
}

//----------------------------------------------
//--------------------------admin custom columns
//----------------------------------------------
//admin_init
add_action('manage_posts_custom_column', 'jss_custom_columns');

add_filter('manage_edit-gallery_columns', 'jss_add_new_gallery_columns');

function jss_add_new_gallery_columns( $columns ){
    $columns = array(
        'cb'                =>        '<input type="checkbox">',
        'jss_post_thumb'    =>        'Thumbnail',
        'title'                =>        'Photo Title',
        'phototype'            =>        'Photo Type',
        'author'            =>        'Author',
        'date'                =>        'Date'

    );
    return $columns;
}

function jss_custom_columns( $column ){
    global $post;

    switch ($column) {
        case 'jss_post_thumb' : echo the_post_thumbnail('admin-list-thumb'); break;
        case 'description' : the_excerpt(); break;
        case 'phototype' : echo get_the_term_list( $post->ID, 'phototype', '', ', ',''); break;
    }
}

//add thumbnail images to column
add_filter('manage_posts_columns', 'jss_add_post_thumbnail_column', 5);
add_filter('manage_pages_columns', 'jss_add_post_thumbnail_column', 5);
add_filter('manage_custom_post_columns', 'jss_add_post_thumbnail_column', 5);

// Add the column
function jss_add_post_thumbnail_column($cols){
    $cols['jss_post_thumb'] = __('Thumbnail');
    return $cols;
}

function jss_display_post_thumbnail_column($col, $id){
  switch($col){
    case 'jss_post_thumb':
      if( function_exists('the_post_thumbnail') )
        echo the_post_thumbnail( 'admin-list-thumb' );
      else
        echo 'Not supported in this theme';
      break;
  }
}



// get all of the images attached to the current post
    function get_gallery_images() {
        global $post;
        $photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
        $galleryimages = array();
        if ($photos) {
            foreach ($photos as $photo) {
                // get the correct image html for the selected size
                $galleryimages[] = wp_get_attachment_url($photo->ID);
            }
        }
        return $galleryimages;
    }

  function load_fonts() {
            wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic|Oswald');

            wp_enqueue_style( 'googleFonts');
        }

    add_action('wp_print_styles', 'load_fonts');



function custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );



add_action( 'save_post', 'uep_save_event_info' );

class Class_Name_Walker extends Walker_Nav_Menu
    {
        /**
         * Start the element output.
         *
         * @param  string $output Passed by reference. Used to append additional content.
         * @param  object $item   Menu item data object.
         * @param  int $depth     Depth of menu item. May be used for padding.
         * @param  array $args    Additional strings.
         * @return void
         */
         function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .$class_names.'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * @see Walker::end_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     */
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
    }



function build_taxonomies() {
register_taxonomy( 'event_categories', 'event', array( 'hierarchical' => true, 'label' => 'Event Categories', 'query_var' => true, 'rewrite' => true ) );
}

add_action( 'init', 'build_taxonomies', 0 );



add_action( 'wp_ajax_nopriv_loginCheck', 'loginCheck' );
add_action( 'wp_ajax_loginCheck', 'loginCheck' );

add_action( 'wp_ajax_logout', 'logout' );

function logout(){

    $return = wp_logout();


    if ( is_wp_error( $return ) ) {
        echo json_encode( array( 'success' => true, 'message' => 'There was an error logging you out' ) );
        die;
    }
    else{
        echo json_encode( array( 'success' => true, 'message' => 'Logout successful' ) );
        die;
    }
}


function loginCheck() {

    if ( is_user_logged_in() ) {

        echo json_encode( array( 'success' => true, 'message' => 'You are already logged in' ) );
        die;
    }

    // check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // get the POSTed credentials
    $creds = array();
    $creds['user_login']    = !empty( $_POST['username'] ) ? $_POST['username'] : null;
    $creds['user_password'] = !empty( $_POST['password'] ) ? $_POST['password'] : null;
    $creds['remember']      = !empty( $_POST['rememberme'] ) ? $_POST['rememberme'] : null;

    // check for empty fields
    if( empty( $creds['user_login'] ) || empty( $creds['user_password'] ) ) {

        echo json_encode( array( 'success' => true, 'message' => 'The username or password is cannot be empty' ) );
        die;
    }

    // check login
    $user = wp_signon( $creds, false );

    if ( is_wp_error( $user ) ) {

        if ( $user->get_error_code() == "invalid_username" || $user->get_error_code() == "incorrect_password" ) {

            echo json_encode( array( 'success' => true, 'message' => 'The username or password is incorrect' ) );
            die;

        } else {

            echo json_encode( array( 'success' => true, 'message' => 'There was an error logging you in' ) );
            die;
        }

        echo json_encode( array( 'success' => true, 'message' => 'Login successful' ) );
        die;
    }

    echo json_encode( $user );
    die;
}

?>
