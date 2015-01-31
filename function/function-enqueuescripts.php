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
    wp_enqueue_style('jquery-ui.theme', get_template_directory_uri() . '/vendor/jquery-ui.theme.css');
    wp_enqueue_style('jquery-ui.structure', get_template_directory_uri() . '/vendor/jquery-ui.structure.css');
    //wp_enqueue_script('events.js', get_template_directory_uri() .'/js/event_buttons.js');

    wp_enqueue_script('jquery.validate', get_template_directory_uri() .'/vendor/jquery.validate.js', array('jquery'));
    wp_enqueue_style('validate.css', get_template_directory_uri() . '/css/validate.css');
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script('events.js', get_template_directory_uri() .'/js/events.js');

    // enque ladda scripts (for loading state bootstrap buttons)
    wp_enqueue_script('spin.min.js', get_template_directory_uri() .'/vendor/spin.min.js');
    wp_enqueue_script('ladda.min.js', get_template_directory_uri() .'/vendor/ladda.min.js');
    wp_enqueue_style('ladda-themeless.min.css', get_template_directory_uri() . '/vendor/ladda-themeless.min.css');


    wp_localize_script('events.js', 'Events', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'addmemberNonce' => wp_create_nonce( 'addmember-nonce' ),
      'removememberNonce' => wp_create_nonce('removemember-nonce'),
      )
    );
    wp_enqueue_script('members.js', get_template_directory_uri() .'/js/members.js');
    wp_localize_script( 'members.js', 'Members', array(
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

add_action( 'admin_enqueue_scripts', 'waf_admin_script_style' );

function waf_admin_script_style( $hook){
  if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
    //  wp_enqueue_script('my_validate', 'path/to/jquery.validate.min.js', array('jquery'));
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/vendor/jquery-ui.js', array('jquery'));
    wp_enqueue_style('jquery-ui.min', get_template_directory_uri() . '/vendor/jquery-ui.css');
    wp_enqueue_script('chosen.jquery', get_template_directory_uri() . '/vendor/chosen.jquery.min.js', array('jquery'));
    wp_enqueue_style('chosen', get_template_directory_uri() . '/vendor/chosen.css');
    wp_enqueue_style('jquery-ui.theme', get_template_directory_uri() . '/vendor/jquery-ui.theme.css');
    wp_enqueue_style('jquery-ui.structure', get_template_directory_uri() . '/vendor/jquery-ui.structure.css');
    wp_enqueue_script( 'admin.js', get_template_directory_uri() . '/js/admin.js' ,false, false, true );
    //wp_register_script('user-details', get_template_directory_uri() . '/js/your-script.js', array( /* dependencies*/ ),1.0,true);

    $users_arr=array();
    global $post;
    $blogusers = get_users( );
    foreach ( $blogusers as $user ) {
      $details=waf_get_details($user->ID,$post->ID);
      $display_name=$user->display_name;
      $user_email=$user->user_email;
      $users_arr["$user->ID"]=array(name=>$display_name,email=>$user_email,details => $details);
    }
    wp_localize_script( 'admin.js', 'Admin', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'addmembersNonce' => wp_create_nonce( 'addmembers-nonce' ),
      'removememberNonce' => wp_create_nonce( 'removemember2-nonce' ),
      'addguestNonce' => wp_create_nonce('addguest-nonce'),
      'removeguestNonce' => wp_create_nonce('removeguest-nonce'),
      'users' => $users_arr,
      )
    );
  }
  if ( 'user-edit.php' == $hook || 'profile.php' == $hook ) {
  wp_enqueue_script( 'admin_user.js', get_template_directory_uri() . '/js/admin_user.js' ,false, false, true );
  wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/vendor/jquery-ui.js', array('jquery'));
  wp_enqueue_style('jquery-ui.min', get_template_directory_uri() . '/vendor/jquery-ui.css');
  }
}




?>
