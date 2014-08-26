<?php
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
add_action('admin_enqueue_scripts', 'add_my_js');
/**
 * Enqueue scripts and styles
 */
function enqueue_scripts() {
    wp_enqueue_style( 'responsive.css', get_template_directory_uri() . '/responsive.css' );
    wp_enqueue_style('doc.min.css', get_template_directory_uri() . '/doc.min.css');
    wp_enqueue_style('style.css', get_template_directory_uri() . '/custom_style.css');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
    wp_enqueue_script( 'responsive.js', get_template_directory_uri() . '/js/responsive.js', false, false, true );
    wp_enqueue_script( 'docs.min.js', get_template_directory_uri() . '/js/docs.min.js' ,false, false, true );
    wp_enqueue_script( 'script.js', get_template_directory_uri() . '/js/script.js' ,false, false, true );
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/vendor/jquery-ui.js', array('jquery'));
    wp_enqueue_script('event_button.js', get_template_directory_uri() .'/js/event_buttons.js');
    wp_enqueue_script('login.js', get_template_directory_uri() .'/js/login.js');
}

function add_my_js(){
//  wp_enqueue_script('my_validate', 'path/to/jquery.validate.min.js', array('jquery'));
  wp_enqueue_script('jquery.validate', get_template_directory_uri() .'/vendor/jquery.validate.js', array('jquery'));
  wp_enqueue_script('validate.js', get_template_directory_uri() .'/js/validate.js');
  wp_enqueue_style('validate.css', get_template_directory_uri() . '/validate.css');
}

function fontawesome_dashboard() {
   wp_enqueue_style('fontawesome', 'https:////netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', '', '4.0.3', 'all');
}

add_action('admin_init', 'fontawesome_dashboard');

/**
*	Use latest jQuery release
*/
if( !is_admin() ){
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("https://code.jquery.com/jquery-latest.min.js"), false, '');
	wp_enqueue_script('jquery');
}
?>
