<?php

add_action( 'show_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'personal_options_update', 'yoursite_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'yoursite_save_extra_user_profile_fields' );


function yoursite_extra_user_profile_fields( $user ) {
?>
  <h3><?php _e("Extra profile information", "blank"); ?></h3>
  <table class="form-table">
    <tr>
      <th><label for="phone"><?php _e("Phone"); ?></label></th>
      <td>
        <input type="text" name="phone" id="phone" class="regular-text"
            value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your phone."); ?></span>
    </td>
    </tr>
  </table>
<?php
}

function yoursite_save_extra_user_profile_fields( $user_id ) {
  $saved = false;
  if ( current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, 'phone', $_POST['phone'] );
    $saved = true;
  }
  return true;
}

function show_users ( $user ) {
  if ( current_user_can( 'manage_options' ) ) {
    /* A user with admin privileges */
    $string = "";
    $blogusers = get_users( 'blog_id=1&orderby=nicename' );
    // Array of WP_User objects.
    foreach ( $blogusers as $user ) {
      $string = $string . '<tr><td><span>' . esc_html( $user->user_email ) . '</span></td></tr>';
    }
    ?>
    <table class="form-table">
      <tr><th>Users</th></tr>
      <?php echo $string; ?>
    </table>
    <?php
  }
}


?>
