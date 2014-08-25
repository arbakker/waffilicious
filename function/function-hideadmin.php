<?php

function remove_read_wpse_93843(){
  remove_cap( 'subscriber', 'read' );
  remove_cap( 'participant', 'read' );
}
add_action( 'admin_init', 'remove_read_wpse_93843' );

function hide_admin_wpse_93843() {
  if ( current_user_can('subscriber') or current_user_can('participant') ) {
    add_filter('show_admin_bar','__return_false');
  }
}
add_action('wp_head','hide_admin_wpse_93843');

function redirect_sub_to_home_wpse_93843( $redirect_to, $request, $user ) {
    if ( isset($user->roles) && is_array( $user->roles ) ) {
      if ( in_array( 'subscriber', $user->roles ) or in_array( 'participant', $user->roles ) ) {
          return home_url( );
      }
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'redirect_sub_to_home_wpse_93843', 10, 3 );

?>
