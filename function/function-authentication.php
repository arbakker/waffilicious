<?php

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
add_action( 'wp_ajax_logout', 'logout' );

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
    //$creds['security']      = !empty( $_POST['security'] ) ? $_POST['security'] : null;

    // check for empty fields
    if( empty( $creds['user_login'] ) || empty( $creds['user_password'] ) ) {
        echo json_encode( array( 'success' => false, 'message' => 'The username or password is cannot be empty' ) );
        die;
    }
    // check login
    $user = wp_signon( $creds, false );
    
    if ( is_wp_error( $user ) ) {
        if ( $user->get_error_code() == "invalid_username" || $user->get_error_code() == "incorrect_password" ) {
            echo json_encode( array(
              'success' => false,
               'message' => 'The username or password is incorrect' ) );
            die;
        } else {
            echo json_encode( array(
              'success' => false,
              'message' => 'There was an error logging you in' ) );
            die;
        }
    }
    if ($user->account_disabled=="on"){
       wp_logout();
       echo json_encode( array(
              'success' => false,
               'message' => 'Your account is disabled.' ) );
            die;
    }

    echo json_encode( array(
      'success' => true,
      'message' => 'Login successful' ,
      'nonce' => check_ajax_referer( 'ajax-login-nonce', 'security' ),
      'display_name' => $user->display_name,
      'user_login' => $user->user_login,
    ) );
    die;
}


function user_login( $user_login, $user = null ) {
  if (!(defined('DOING_AJAX') && DOING_AJAX)) {
  setcookie( 'account_disabled', '0',time()+600, COOKIEPATH, COOKIE_DOMAIN, false);
    if ( !$user ) {
      $user = get_user_by('login', $user_login);
    }
    if ( !$user ) {
      // not logged in - definitely not disabled
      return;
    }
    // Get user meta
    $disabled = get_user_meta( $user->ID, 'account_disabled', true );
    
    // Is the use logging in disabled?
    if ( $disabled === "on" ) {
      // Clear cookies, a.k.a log user out
      wp_clear_auth_cookie();

      // Build login URL and then redirect
      $login_url = add_query_arg( 'disabled', '1', $login_url );
      setcookie( 'account_disabled', '1',time()+600, COOKIEPATH, COOKIE_DOMAIN, false);
      wp_redirect( $login_url );
      exit;
    }
  }
}

function user_login_message( $message ) {

    // Show the error message if it seems to be a disabled user
    if ( isset( $_GET['disabled'] ) && $_GET['disabled'] == 1 ) 
      $message =  '<div id="login_error">' . apply_filters( 'ja_disable_users_notice', __( 'Your account is disabled.', 'account_disabled' ) ) . '</div>';

    return $message;
  }

add_action( 'wp_ajax_nopriv_loginCheck', 'loginCheck' );
add_action( 'wp_ajax_loginCheck', 'loginCheck' );
add_action( 'wp_login',  'user_login');
add_filter( 'login_message', 'user_login_message');


function check_user_role( $role, $user_id = null ) {
    if ( is_numeric( $user_id ) ){
      $user = get_userdata( $user_id );
    }
    else{
      $user = wp_get_current_user();
    }
    if ( empty( $user ) ){
      return false;
    }
    else{
      return in_array( $role, (array) $user->roles );
    }
}

// function that hides admin bar for participants and subscribers
function hide_admin_bar() {
  if ( check_user_role("subscriber") or check_user_role("participant")){
    show_admin_bar(false);
  }
  }
add_action('set_current_user', 'hide_admin_bar');

// function that redirects users that are participant or subscriber to home page
function redirect_sub_to_home( $redirect_to, $request, $user ) {
    if ( isset($user->roles) && is_array( $user->roles ) ) {
      if ( in_array( 'subscriber', $user->roles ) or in_array( 'participant', $user->roles ) ) {
          return home_url( );
      }
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'redirect_sub_to_home', 10, 3 );


function redirect_non_admin_user(){
    if ( !defined( 'DOING_AJAX' ) && current_user_can('contributor') ){
        wp_redirect( site_url() );  exit;
    } 
}

add_action( 'admin_init', 'redirect_non_admin_user' );



// function for adding styling when user is logged in, makes sure that the page does not overlap with the wp-admin toolbar
function waf_wp_head(){
    echo '<style>'.PHP_EOL;
    echo '@media(max-width:48em) { '.PHP_EOL;
    echo 'body{ padding-top: 22px !important; }'.PHP_EOL;
    echo 'body.logged-in .navbar{ top: 46px !important; }'.PHP_EOL;
    echo '}' . PHP_EOL;
    echo '@media(min-width:48em) { '.PHP_EOL;
    echo 'body{ padding-top: 36px !important; }'.PHP_EOL;
    echo 'body.logged-in .navbar{ top: 28px !important; }'.PHP_EOL;
    echo '}' . PHP_EOL;
    echo '@media screen and (max-width: 782px) {'.PHP_EOL;
    echo 'body{ padding-top: 46px !important; }'.PHP_EOL;
    echo 'body.logged-in .navbar{ top: 46px !important; }'.PHP_EOL;
    echo '}' . PHP_EOL;
    echo '</style>'.PHP_EOL;
}
add_action('wp_head', 'waf_wp_head');

// function to remove the class .logged-in from the body when a subcriber or participant is logged in
function waf_body_class( $wp_classes, $extra_classes )
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
add_filter( 'body_class', 'waf_body_class', 10, 2 );

/**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
function themeblvd_redirect_admin(){
  if ( ! defined('DOING_AJAX') && ! current_user_can('edit_posts') ) {
    wp_redirect( site_url() );
    exit;   
  }
}
add_action( 'admin_init', 'themeblvd_redirect_admin' );
?>
