<?php

add_action( 'show_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'personal_options_update', 'yoursite_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'yoursite_save_extra_user_profile_fields' );


function yoursite_extra_user_profile_fields( $user ) {
/* TODO: Change institue, veggie input to radio inputs

*/

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
    <tr>
      <th><label for="adress"><?php _e("Adress"); ?></label></th>
      <td>
        <input type="text" name="adress" id="adress" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'adress', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your adress."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="WBA_ID"><?php _e("WBA ID"); ?></label></th>
      <td>
        <input type="text" name="WBA_ID" id="WBA_ID" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'WBA_ID', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your WBA ID."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="studentnr"><?php _e("Student number"); ?></label></th>
      <td>
        <input type="text" name="studentnr" id="studentnr" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'studentnr', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your student registration number."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="veggie"><?php _e("Veggie"); ?></label></th>
      <td>
        <input type="text" name="veggie" id="veggie" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'veggie', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Veggie?."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="institution"><?php _e("Institution"); ?></label></th>
      <td>
        <input type="text" name="institution" id="institution" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'institution', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Institute (VHL/WUR)."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="allergies"><?php _e("Allergies"); ?></label></th>
      <td>
        <input type="text" name="allergies" id="allergies" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'allergies', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Food allergies."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="member_type"><?php _e("Type of member"); ?></label></th>
      <td>
        <input type="text" name="member_type" id="member_type" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'member_type', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Type of student (regular/phd/verenigingskaart)."); ?></span>
      </td>
    </tr>
  </table>
<?php
}

function yoursite_save_extra_user_profile_fields( $user_id ) {
  $saved = false;
  if ( current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, 'phone', $_POST['phone'] );
    update_user_meta( $user_id, 'adress', $_POST['adress'] );
    update_user_meta( $user_id, 'WBA_ID', $_POST['WBA_ID'] );
    update_user_meta( $user_id, 'studentnr', $_POST['studentnr'] );
    update_user_meta( $user_id, 'veggie', $_POST['veggie'] );
    update_user_meta( $user_id, 'institute', $_POST['institute'] );
    update_user_meta( $user_id, 'allergies', $_POST['allergies'] );
    update_user_meta( $user_id, 'member_type', $_POST['member_type'] );
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

add_action('wp_ajax_updatememberdetails', 'updatememberdetails_ajax');
function updatememberdetails_ajax() {

  $nonce = $_POST['memberNonce'];
  if ( ! wp_verify_nonce( $nonce, 'myajax-member-nonce' ))
  die ( 'Busted!');

  // Check current user
  $current_user = wp_get_current_user();
  $roles=$user->roles;
  $userid=intval($current_user->ID);
  // Get ajax request post parameters

  $displayname = $_POST['displayname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $telephone = $_POST['telephone'];
  $member = intval($_POST['member']);

  // Check if member edits own userdetails or has rights to edit post
  // TODO: Check if user can edit user, if so change user details
  if ($member==$userid ){

    $result=true;
    $message = "You have succesfully changed the user info";
  }else{
    $result=false;
    $message="You are not allowed to create, update or delete user information for other users than yourself.";
  }

  if ($result===true){
    $return = array(
      'result' => $result,
      'message'	=> $message,
      'nonce' => $nonce,
      'email' => $email,
      'displayname' => $displayname,
    );
    wp_send_json_success($return);
  }
  else{
    $return = array(
      'result'	=> $result,
      'message' => $message,
      );
      wp_send_json_error($return);
    }
  }





?>
