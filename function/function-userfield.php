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

  
<?php 
//
// Add userinfo here that only admins can view/change
//
if ( current_user_can( 'manage_options' ) ) { ?>
    <tr>
      <th><label for="account_disabled"><?php _e("Account Disabled"); ?></label></th>
      <td>
        <?php $account_disabled=esc_attr( get_the_author_meta( 'account_disabled', $user->ID ) );
        
        ?>
          <INPUT  type="checkbox"  name="account_disabled" id="account_disabled"<?php if ($account_disabled==="on"){echo "checked";} ?>>
          <span class="description"><?php _e("Account Disabled"); ?></span>
        </td>
    </tr>
    <tr>
      <th><label for="registered_scb"><?php _e("Register with SCB"); ?></label></th>
      <td>
        <?php $registered_scb=esc_attr( get_the_author_meta( 'registered_scb', $user->ID ) );
        
        ?>
          <INPUT  type="checkbox"  name="registered_scb" id="registered_scb"<?php if ($registered_scb==="on"){echo "checked";} ?>>
          <span class="description"><?php _e("Registered with SCB"); ?></span>
        </td>
    </tr>
    <tr>
      <th><label for="registered_nfb"><?php _e("Register with NFB"); ?></label></th>
      <td>
        <?php $registered_nfb=esc_attr( get_the_author_meta( 'registered_nfb', $user->ID ) );
        
        ?>
          <INPUT  type="checkbox"  name="registered_nfb" id="registered_nfb"<?php if ($registered_nfb==="on"){echo "checked";} ?>>
          <span class="description"><?php _e("Registered with NFB"); ?></span>
        </td>
    </tr>
     <tr>
      <th><label for="start_member"><?php _e("Start membership"); ?></label></th>
      <td>
        <input class="date" id="start_member" type="text" name="start_member" value="<?php echo  esc_attr( get_the_author_meta( 'start_member', $user->ID ) ) ; ?>" />
        <br />
        <span class="description"><?php _e("Set start of membership"); ?></span>
      </td>
    </tr>
     <tr>
      <th><label for="end_member"><?php _e("End membership"); ?></label></th>
      <td>
        <input class="date" id="end_member" type="text" name="end_member" value="<?php echo  esc_attr( get_the_author_meta( 'end_member', $user->ID ) ) ; ?>" />
        <br />
        <span class="description"><?php _e("Set end of membership."); ?></span>
      </td>
    </tr>
    <?php
}
     ?>
    <tr>
      <th><label for="phone"><?php _e("Phone"); ?></label></th>
      <td>
        <input type="text" name="phone" id="phone" class="regular-text"
            value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your phone nr.."); ?></span>
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
      <th><label for="postal_code"><?php _e("Postal Code"); ?></label></th>
      <td>
        <input type="text" name="postal_code" id="postal_code" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'postal_code', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your postal code."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="city"><?php _e("City"); ?></label></th>
      <td>
        <input type="text" name="city" id="city" class="regular-text"
        value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your city."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="dob"><?php _e("Date of Birth"); ?></label></th>
      <td>
        <input class="date" id="dob" type="text" name="dob" value="<?php echo  esc_attr( get_the_author_meta( 'dob', $user->ID ) ) ; ?>" />
        <br />
        <span class="description"><?php _e("Please enter your date of birth."); ?></span>
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
      <th><label for="member_type"><?php _e("Type of member"); ?></label></th>
      <td>
        <select id='member_type' name="member_type">
          <?php $member_type= esc_attr( get_the_author_meta( 'member_type', $user->ID ) ); ?>
          <option <?php if ($member_type=="Student" or $member_type==="") echo 'selected="selected"'; ?>>Student</option>
          <option <?php if ($member_type=="PHD") echo 'selected="selected"'; ?>>PHD</option>
          <option <?php if ($member_type=="Clubcard") echo 'selected="selected"'; ?>>Clubcard</option>
          <option <?php if ($member_type=="Employee") echo 'selected="selected"'; ?>>Employee</option>
          <option <?php if ($member_type=="Trainer") echo 'selected="selected"'; ?>>Trainer</option>
        </select>
        <br />
        <span class="description"><?php _e("Type of student (student/phd/clubcar/employee/trainer)."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="veggie"><?php _e("Veggie"); ?></label></th>
      <td>
        <?php $veggie=esc_attr( get_the_author_meta( 'veggie', $user->ID ) );
        ?>
        <INPUT  type="checkbox"  name="veggie" id="veggie"<?php if ($veggie){echo "checked";} ?>>
          <span class="description"><?php _e("Veggie?"); ?></span>
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

  </table>
<?php
}

function yoursite_save_extra_user_profile_fields( $user_id ) {
  $saved = false;
  if ( current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, 'phone', $_POST['phone'] );
    update_user_meta( $user_id, 'adress', $_POST['adress'] );
    update_user_meta( $user_id, 'postal_code', $_POST['postal_code'] );
    update_user_meta( $user_id, 'city', $_POST['city'] );
    update_user_meta( $user_id, 'WBA_ID', $_POST['WBA_ID'] );
    update_user_meta( $user_id, 'studentnr', $_POST['studentnr'] );
    update_user_meta( $user_id, 'veggie', $_POST['veggie'] );
    update_user_meta( $user_id, 'allergies', $_POST['allergies'] );
    update_user_meta( $user_id, 'member_type', $_POST['member_type'] );
    update_user_meta( $user_id, 'dob', $_POST['dob'] );
    $saved = true;
  }
  if ( current_user_can( 'manage_options' ) ) {
    update_user_meta( $user_id, 'account_disabled', $_POST['account_disabled'] );
    update_user_meta( $user_id, 'registered_scb', $_POST['registered_scb'] );
    update_user_meta( $user_id, 'registered_nfb', $_POST['registered_nfb'] );
    update_user_meta( $user_id, 'start_member', $_POST['start_member'] );
    update_user_meta( $user_id, 'end_member', $_POST['end_member'] );
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

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}


add_action('wp_ajax_updatememberdetails', 'updatememberdetails_ajax');
function updatememberdetails_ajax() {

  $nonce = $_POST['memberNonce'];
  if ( ! wp_verify_nonce( $nonce, 'myajax-member-nonce' )){
    $return = array(
      'message' => "Could not update member details, nonce could not be verified.",
    );
    wp_send_json_error($return);
  }

  // Check current user
  $current_user = wp_get_current_user();
  $roles=$user->roles;
  $userid=intval($current_user->ID);

  // Get member post parameter
  $member = intval($_POST['member']);


  // Check if member edits own userdetails or has rights to edit user

  if ($member==$userid or current_user_can('edit_user', $member )){
    // Check if post parameter was used in request, if so extract and update user meta
    if(array_key_exists('account_disabled', $_POST) == TRUE){
      $account_disabled = sanitize_text_field($_POST['account_disabled']);
      update_user_meta( $member, 'account_disabled', $account_disabled );}
    if(array_key_exists('telephone', $_POST) == TRUE){
      $telephone =sanitize_text_field( $_POST['telephone']);
      update_user_meta( $member, 'phone', $telephone );}
    if(array_key_exists('firstname', $_POST) == TRUE){
      $firstname =sanitize_text_field( $_POST['firstname']);
      wp_update_user( array( 'ID' => $member,' first_name ' => $firstname ));}
    if(array_key_exists('lastname', $_POST) == TRUE){
      $lastname =sanitize_text_field( $_POST['lastname']);
      wp_update_user( array( 'ID' => $member,'last_name' => $lastname ));}
    $user_info = get_userdata($member);
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    wp_update_user( array( 'ID' => $member,'display_name' => $firstname." ".$lastname));
    if(array_key_exists('veggie', $_POST) == TRUE){
      $veggie = sanitize_text_field($_POST['veggie']);
      update_user_meta( $member, 'veggie', $veggie );}
    if(array_key_exists('adress', $_POST) == TRUE){
      $adress = sanitize_text_field($_POST['adress']);
      update_user_meta( $member, 'adress', $adress );}
    if(array_key_exists('postal_code', $_POST) == TRUE){
      $postal_code = sanitize_text_field($_POST['postal_code']);
      update_user_meta( $member, 'postal_code', $postal_code );}
    if(array_key_exists('city', $_POST) == TRUE){
      $city = sanitize_text_field($_POST['city']);
      update_user_meta( $member, 'city', $city );}
    if(array_key_exists('WBA_ID', $_POST) == TRUE){
      $WBA_ID = sanitize_text_field($_POST['WBA_ID']);
      update_user_meta( $member, 'WBA_ID', $WBA_ID );}
    if(array_key_exists('studentnr', $_POST) == TRUE){
      $studentnr = sanitize_text_field($_POST['studentnr']);
      update_user_meta( $member, 'studentnr', $studentnr );}
    if(array_key_exists('allergies', $_POST) == TRUE){
      $allergies = sanitize_text_field($_POST['allergies']);
      update_user_meta( $member, 'allergies', $allergies );
      }
    if(array_key_exists('member_type', $_POST) == TRUE){
      $member_type = sanitize_text_field($_POST['member_type']);
      update_user_meta( $member, 'member_type', $member_type );}
    if(array_key_exists('institute', $_POST) == TRUE){
      $institute = sanitize_text_field($_POST['institute']);
      update_user_meta( $member, 'institute', $institute );}
    if(array_key_exists('dob', $_POST) == TRUE){
      $dob = sanitize_text_field($_POST['dob']);
      update_user_meta( $member, 'dob', $dob );}
    if(array_key_exists('email', $_POST) == TRUE){
      $email = sanitize_text_field($_POST['email']);
      wp_update_user( array( 'ID' => $member,'user_email' => $email ));}
      if(array_key_exists('password', $_POST) == TRUE){
        $password = sanitize_text_field($_POST['password']);
        wp_update_user( array( 'ID' => $member,'user_pass' => $password ));}


    $result=true;
    $message = "You have succesfully changed the user info";
  }else{
    $result=false;
    $message="You are not allowed to create, update or delete user information for other users than yourself.";
  }

  if ($result===true){
    $return = array(
      'message'	=> $message,
      'can' => current_user_can('edit_user', $member ),
      'member' => $member,
      'user' => $userid,
    );
    wp_send_json_success($return);
  }
  else{
    $return = array(
      'message' => $message,
      'can'=> current_user_can('edit_user', $member ),
      );
      wp_send_json_error($return);
    }
  }







?>
