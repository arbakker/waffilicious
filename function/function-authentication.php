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
add_action( 'wp_ajax_nopriv_loginCheck', 'loginCheck' );
add_action( 'wp_ajax_loginCheck', 'loginCheck' );

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

// not sure what the function of this function is
function restrict_admin()
{
  if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
                wp_redirect( site_url() );
  }
}
add_action( 'admin_init', 'restrict_admin', 1 );

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
?>
