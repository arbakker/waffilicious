<?php
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
add_action('admin_enqueue_scripts', 'enqueue_scripts_admin');
/**
*	Use latest jQuery release
*/



/**
 * Enqueue scripts and styles
 */
function enqueue_scripts() {
   

    // Vendor scripts
    wp_deregister_script('jquery');
    wp_register_script('jquery',get_template_directory_uri(). '/dist/jquery.min.js', false );
    wp_enqueue_script('jquery');
    wp_enqueue_script('vendor-main', get_template_directory_uri() . '/dist/vendor_main.min.js', array('jquery'));

    // Vendor css
    wp_enqueue_style( 'vendor_main.css', get_template_directory_uri() . '/dist/vendor_main.css' );    
   
     // User scripts
    wp_enqueue_script('main.js', get_template_directory_uri() .'/dist/main.js');

    wp_enqueue_style( 'main.css', get_template_directory_uri() . '/dist/main.css' ); 


    wp_localize_script('main.js', 'Events', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'addmemberNonce' => wp_create_nonce( 'addmember-nonce' ),
      'removememberNonce' => wp_create_nonce('removemember-nonce'),
      )
    );
    wp_localize_script( 'main.js', 'Members', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'memberNonce' => wp_create_nonce( 'myajax-member-nonce' )
      )
    );
}

function enqueue_scripts_admin(){
  wp_deregister_script('jquery');
  wp_register_script('jquery',get_template_directory_uri(). '/dist/jquery.min.js', false );
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery.validate', get_template_directory_uri() .'/vendors/jquery-validation/jquery.validate.js', array('jquery'));
  wp_enqueue_style('font_awesome', get_template_directory_uri() .'/vendors/font-awesome/font-awesome.min.css');
  wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/vendors/jquery-ui/jquery-ui.js', array('jquery'));
  wp_enqueue_script('validate.js', get_template_directory_uri() .'/js/validate.js');
  wp_enqueue_style('validate.css', get_template_directory_uri() . '/css/validate.css');
}


function load_fonts() {
          wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic|Oswald:400');
          wp_enqueue_style( 'googleFonts');

      }
add_action('wp_print_styles', 'load_fonts');

add_action( 'admin_enqueue_scripts', 'waf_admin_script_style' );

function waf_admin_script_style( $hook){
  if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
  
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/dist/jquery-ui.min.js', array('jquery'));
    wp_enqueue_script('timepicker.js',get_template_directory_uri(). '/dist/datetimepicker.min.js', array('jquery') );
    wp_enqueue_script('chosen.jquery', get_template_directory_uri() . '/dist/chosen.jquery.min.js', array('jquery'));
    
    wp_enqueue_style('chosen', get_template_directory_uri() . '/dist/chosen.min.css');
    wp_enqueue_style('timepicker.css', get_template_directory_uri() . '/dist/jquery.datetimepicker.min.css');
    wp_enqueue_style('jquery-ui.min', get_template_directory_uri() . '/dist/jquery-ui.min.css');
    wp_enqueue_style('jquery-ui.theme', get_template_directory_uri() . '/dist/jquery-ui.theme.min.css');

    wp_enqueue_script( 'admin.js', get_template_directory_uri() . '/dist/admin.js' ,false, false, true );
    
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
  wp_enqueue_script( 'admin.js', get_template_directory_uri() . '/dist/admin.js' ,false, false, true );
  wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/dist/jquery-ui.min.js', array('jquery'));
  wp_enqueue_style('jquery-ui.min', get_template_directory_uri() . '/dist/jquery-ui.min.css');
  }
}




?>
