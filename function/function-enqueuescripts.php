<?php
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
add_action('admin_enqueue_scripts', 'enqueue_scripts_admin');
/**
*	Use latest jQuery release
*/

wp_deregister_script('jquery');
wp_register_script('jquery',get_template_directory_uri(). '/vendor/jquery-2.1.1.min.js', false );
wp_enqueue_script('jquery');

/**
 * Enqueue scripts and styles
 */
function enqueue_scripts() {
    wp_enqueue_style( 'bootstrap.css', get_template_directory_uri() . '/css/bootstrap.min.css' );
    //wp_enqueue_style('responsive.css', get_template_directory_uri() . '/css/responsive.css');
    //wp_enqueue_style('doc.min.css', get_template_directory_uri() . '/css/doc.min.css');
    wp_enqueue_style('style.css', get_template_directory_uri() . '/css/style.css');
    wp_enqueue_script( 'bootstrap.js', get_template_directory_uri() . '/js/bootstrap.min.js', false, false, true );
    //wp_enqueue_script( 'docs.min.js', get_template_directory_uri() . '/js/docs.min.js' ,false, false, true );
    wp_enqueue_script( 'script.js', get_template_directory_uri() . '/js/script.js' ,false, false, true );
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/vendor/jquery-ui.js', array('jquery'));

    wp_enqueue_script('login.js', get_template_directory_uri() .'/js/login.js');
    wp_enqueue_style('font_awesome', get_template_directory_uri() .'/css/font-awesome.css');
    wp_enqueue_script( 'jquery' );
    wp_enqueue_style('font_awesome', get_template_directory_uri() .'/css/font-awesome.css');
    wp_enqueue_style('fonts', get_template_directory_uri() .'/css/fonts.css');
    wp_enqueue_script( 'parallax', get_template_directory_uri() . '/vendor/jquery-imageScroll.min.js', false, false, true );
    //wp_enqueue_script('events.js', get_template_directory_uri() .'/js/event_buttons.js');
    wp_enqueue_script('events.js', get_template_directory_uri() .'/js/events.js');
    wp_localize_script( 'events.js', 'PT_Ajax', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'nextNonce' => wp_create_nonce( 'myajax-next-nonce' )
      )
    );

    wp_enqueue_script('members.js', get_template_directory_uri() .'/js/members.js');
    wp_localize_script( 'members.js', 'PT_Ajax', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'memberNonce' => wp_create_nonce( 'myajax-member-nonce' )
      )
    );




}

function enqueue_scripts_admin(){
  wp_enqueue_script('jquery.validate', get_template_directory_uri() .'/vendor/jquery.validate.js', array('jquery'));
  wp_enqueue_script('validate.js', get_template_directory_uri() .'/js/validate.js');
  wp_enqueue_style('validate.css', get_template_directory_uri() . '/css/validate.css');
  wp_enqueue_script( 'jquery' );
}


function load_fonts() {
          wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic|Oswald');
          wp_enqueue_style( 'googleFonts');

      }
add_action('wp_print_styles', 'load_fonts');




?>
