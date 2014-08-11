<?php
/**
 * minim2 functions and definitions
 *
 * @package minim2
 * @since minim2 1.0
 */

 /**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since minim2 1.0
 */
add_action('wp_head', 'mbe_wp_head');
if ( ! isset( $content_width ) )
    $content_width = 654; /* pixels */

if ( ! function_exists( 'minim2_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since minim2 1.0
 */
function minim2_setup() {

    /**
     * Custom template tags for this theme.
     */
    require( get_template_directory() . '/inc/template-tags.php' );

    /**
     * Custom functions that act independently of the theme templates
     */
    require( get_template_directory() . '/inc/tweaks.php' );

    /**
     * Make theme available for translation
     * Translations can be filed in the /languages/ directory
     * If you're building a theme based on minim2, use a find and replace
     * to change 'minim2' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'minim2', get_template_directory() . '/languages' );

    /**
     * Add default posts and comments RSS feed links to head
     */
    add_theme_support( 'automatic-feed-links' );

    /**
     * Enable support for the Aside Post Format
     */
    add_theme_support( 'post-formats', array( 'aside' ) );
    add_theme_support( 'post-thumbnails' );

    /**
     * This theme uses wp_nav_menu() in one location.
     */
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'minim2' ),
    ) );
}
endif; // minim2_setup
add_action( 'after_setup_theme', 'minim2_setup' );

/**
 * Enqueue scripts and styles
 */
function shape_scripts() {
    wp_enqueue_style( 'responsive', get_template_directory_uri() . '/responsive.css' );
    wp_enqueue_style('doc.min', get_template_directory_uri() . '/doc.min.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/custom_style.css');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
    wp_enqueue_script( 'responsive.js', get_template_directory_uri() . '/responsive.js', false, false, true );
    wp_enqueue_script( 'docs.min.js', get_template_directory_uri() . '/docs.min.js' ,false, false, true );

}


function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function my_special_nav_class( $classes, $item ) {

    if ( is_single() && $item->title == 'About' ) {
        $classes[] = 'special-class';
    }

    return $classes;

}



if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}




add_action( 'wp_enqueue_scripts', 'shape_scripts' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Shape 1.0
 */
function shape_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Primary Widget Area', 'minim2' ),
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ) );

    register_sidebar( array(
        'name' => __( 'Secondary Widget Area', 'minim2' ),
        'id' => 'sidebar-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'shape_widgets_init' );

$args = array(
	'flex-width'    => true,
	'width'         => 2400,
	'flex-width'    => true,
	'height'        => 320,
	'default-image' => get_template_directory_uri() . '/images/header.jpg',
	'uploads'       => true,
);
add_theme_support( 'custom-header', $args );
add_theme_support( 'custom-background', $args );
add_theme_support( 'post-thumbnails' );

$args = array(
	'default-color' => 'DCDCDC'
);

add_action( 'init', 'my_add_excerpts_to_pages' );

function my_add_excerpts_to_pages() {
add_post_type_support( 'page', 'excerpt' );
}

function mbe_body_class($classes){
    if(is_user_logged_in()){
        $classes[] = 'body-logged-in';
    } else{
        $classes[] = 'body-logged-out';
    }
    return $classes;
}

function mbe_wp_head(){
    echo '<style>'.PHP_EOL;
    echo 'body{ padding-top: 36px !important; }'.PHP_EOL;
    // Using custom CSS class name.
    echo 'body.body-logged-in .navbar{ top: 28px !important; }'.PHP_EOL;
    // Using WordPress default CSS class name.
    echo 'body.logged-in .navbar{ top: 28px !important; }'.PHP_EOL;
    echo '</style>'.PHP_EOL;
}

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

//----------------------------------------------
//----------register and label gallery post type
//----------------------------------------------
$products_labels = array(
    'name' => _x('Products', 'post type general name'),
    'singular_name' => _x('Product', 'post type singular name'),
    'add_new' => _x('Add New', 'product'),
    'add_new_item' => __("Add New Product"),
    'edit_item' => __("Edit Product"),
    'new_item' => __("New Product"),
    'view_item' => __("View Product"),
    'search_items' => __("Search Product"),
    'not_found' =>  __('No products found'),
    'not_found_in_trash' => __('No products found in Trash'),
    'parent_item_colon' => ''

);
$products_args = array(
    'labels' => $products_labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'rewrite' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'products'),
    'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
    'menu_icon' => get_bloginfo('template_directory') . '/images/products.png' //16x16 png if you want an icon
);
register_post_type('products', $products_args);

function my_taxonomies_product() {
  $labels = array(
    'name'              => _x( 'Product Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Product Categories' ),
    'all_items'         => __( 'All Product Categories' ),
    'parent_item'       => __( 'Parent Product Category' ),
    'parent_item_colon' => __( 'Parent Product Category:' ),
    'edit_item'         => __( 'Edit Product Category' ),
    'update_item'       => __( 'Update Product Category' ),
    'add_new_item'      => __( 'Add New Product Category' ),
    'new_item_name'     => __( 'New Product Category' ),
    'menu_name'         => __( 'Product Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );

  register_taxonomy( 'product_category', 'product', $args );

}


add_action( 'init', 'my_taxonomies_product', 0 );




add_action("admin_init", "admin_init");

function admin_init(){
  add_meta_box("price", "Price", "price", "products", "side", "low");
}


function price() {
  global $post;
  $custom = get_post_custom($post->ID);
  $price = $custom["price"][0];
  ?>
  <label>Price:</label>
  <input name="price" value="<?php echo $price; ?>" />
  <?php
}
add_action('save_post', 'save_details');

function save_details(){
  global $post;

  update_post_meta($post->ID, "price", $_POST["price"]);

}

add_action("manage_posts_custom_column",  "product_custom_columns");
add_filter("manage_edit-products_columns", "product_edit_columns");

function product_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" >",
    'jss_post_thumb'    =>        'Thumbnail',
    "title" => "Product",
    "description" => "Description",
    "price" => "Price",
  );

  return $columns;
}

function product_custom_columns($column){
  global $post;

  switch ($column) {

    case "price":
      $custom = get_post_custom();
      echo $custom["price"][0];
      break;

  }
}
// ---
// --- End of Products section
// ---


//----------------------------------------------
//----------register and label tournament post type
//----------------------------------------------
$tournaments_labels = array(
    'name' => _x('Tournaments', 'post type general name'),
    'singular_name' => _x('Tournament', 'post type singular name'),
    'add_new' => _x('Add New', 'tournament'),
    'add_new_item' => __("Add New Tournament"),
    'edit_item' => __("Edit Tournament"),
    'new_item' => __("New Tournament"),
    'view_item' => __("View Tournament"),
    'search_items' => __("Search Tournament"),
    'not_found' =>  __('No tournaments found'),
    'not_found_in_trash' => __('No tournaments found in Trash'),
    'parent_item_colon' => ''

);
$tournaments_args = array(
    'labels' => $tournaments_labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'rewrite' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'tournaments'),
    'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
    'menu_icon' => get_bloginfo('template_directory') . '/images/tournaments.png' //16x16 png if you want an icon
);
register_post_type('tournaments', $tournaments_args);

function my_taxonomies_tournament() {
  $labels = array(
    'name'              => _x( 'Tournament Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Tournament Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Tournament Categories' ),
    'all_items'         => __( 'All Tournament Categories' ),
    'parent_item'       => __( 'Parent Tournament Category' ),
    'parent_item_colon' => __( 'Parent Tournament Category:' ),
    'edit_item'         => __( 'Edit Tournament Category' ),
    'update_item'       => __( 'Update Tournament Category' ),
    'add_new_item'      => __( 'Add New Tournament Category' ),
    'new_item_name'     => __( 'New Tournament Category' ),
    'menu_name'         => __( 'Tournament Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );

  register_taxonomy( 'tournament_category', 'tournament', $args );

}


add_action( 'init', 'my_taxonomies_tournament', 0 );




add_action("admin_init", "admin_init_tournament");

function admin_init_tournament(){
  add_meta_box("costs", "Costs", "costs", "tournaments", "side", "low");
}


function costs() {
  global $post;
  $custom = get_post_custom($post->ID);
  $price = $custom["costs"][0];
  ?>
  <label>Costs:</label>
  <input name="price" value="<?php echo $costs; ?>" />
  <?php
}
add_action('save_post', 'save_details_tournament');

function save_details_tournament(){
  global $post;

  update_post_meta($post->ID, "costs", $_POST["price"]);

}

add_action("manage_posts_custom_column",  "tournament_custom_columns");
add_filter("manage_edit-tournaments_columns", "tournament_edit_columns");

function tournament_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" >",
    'jss_post_thumb'    =>        'Thumbnail',
    "title" => "Tournament",
    "description" => "Description",
    "costs" => "Costs",
  );

  return $columns;
}

function tournament_custom_columns($column){
  global $post;

  switch ($column) {
    case "costs":
      $custom = get_post_custom();
      echo $custom["costs"][0];
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
            wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic|Oswald');

            wp_enqueue_style( 'googleFonts');
        }

    add_action('wp_print_styles', 'load_fonts');



function custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
