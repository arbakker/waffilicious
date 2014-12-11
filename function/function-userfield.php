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
      <th><label for="dob"><?php _e("Date of Birth"); ?></label></th>
      <td>
        <input class="date" id="dob" type="text" value="<?php echo  esc_attr( get_the_author_meta( 'dob', $user->ID ) ) ; ?>" />
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
          <option <?php if ($member_type=="Trainer") echo 'selected="selected"'; ?>>Trainer</option>
        </select>
        <br />
        <span class="description"><?php _e("Type of student (regular/phd/verenigingskaart)."); ?></span>
      </td>
    </tr>
    <tr>
      <th><label for="institute"><?php _e("Institution"); ?></label></th>
      <td>
        <select id='institute' name="institute">
          <?php $institute=esc_attr( get_the_author_meta( 'institute', $user->ID ) ); echo esc_attr( get_the_author_meta( 'institute', $user->ID ) );?>

          <option <?php if ($institute=="WUR") echo 'selected="selected"'; ?> value="WUR">WUR</option>
          <option <?php if ($institute=="VHL") echo 'selected="selected"'; ?> value="VHL">VHL</option>
          <option <?php if ($institute=="None" or $institute==="") echo 'selected="selected"'; ?> value="None">None</option>
          <option <?php if ($institute=="Other") echo 'selected="selected"'; ?> value="Other">Other</option>
        </select>
       <br />
        <span class="description"><?php _e("Institute (VHL/WUR)."); ?></span>
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
    update_user_meta( $user_id, 'WBA_ID', $_POST['WBA_ID'] );
    update_user_meta( $user_id, 'studentnr', $_POST['studentnr'] );
    update_user_meta( $user_id, 'veggie', $_POST['veggie'] );
    update_user_meta( $user_id, 'institute', $_POST['institute'] );
    update_user_meta( $user_id, 'allergies', $_POST['allergies'] );
    update_user_meta( $user_id, 'member_type', $_POST['member_type'] );
    update_user_meta( $user_id, 'dob', $_POST['dob'] );
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
    if(array_key_exists('telephone', $_POST) == TRUE){
      $telephone =sanitize_text_field( $_POST['telephone']);
      update_user_meta( $member, 'phone', $telephone );}
    if(array_key_exists('display_name', $_POST) == TRUE){
      $displayname =sanitize_text_field( $_POST['displayname']);
      wp_update_user( array( 'ID' => $member,'display_name' => $displayname ));}
    if(array_key_exists('veggie', $_POST) == TRUE){
      $veggie = sanitize_text_field($_POST['veggie']);
      update_user_meta( $member, 'veggie', $veggie );}
    if(array_key_exists('adress', $_POST) == TRUE){
      $adress = sanitize_text_field($_POST['adress']);
      update_user_meta( $member, 'adress', $adress );}
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
