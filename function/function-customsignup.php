<?php

function registration_form( $username, $password, $email, $website, $first_name, $last_name ) {
    echo '
    <style>
    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
    </style>
    ';
 
    echo '
    <form class="form-horizontal" id="userdetails" action="' . $_SERVER['REQUEST_URI'] . '" method="post">
        
        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="username">Username</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="username" name="username" value="' . ( isset( $_POST['username']) ? $username : null ) . '">
            </div>
        </div>

        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="password">Password</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="password" id="password" name="password" value="' . ( isset( $_POST['password']) ? $password : null ) . '">
            </div>
        </div>

         <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="email">Email</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="email" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
            </div>
        </div>
               <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="fname">First Name</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="fname" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
            </div>
        </div>

         <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="lname">Last Name</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="lname" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
            </div>
        </div>

         <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="address">Address</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" name="address" id="address" value="' . ( isset( $_POST['address']) ? $address : null ) . '">
            </div>
        </div>
     
        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="postal_code">Postal Code</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" name="postal_code" id="postal_code" value="' . ( isset( $_POST['postal_code']) ? $postal_code : null ) . '">
            </div>
        </div>

         <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="city">City</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" name="city" id="city" value="' . ( isset( $_POST['city']) ? $city : null ) . '">
            </div>
        </div>

        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="telephone">Telephone nr.</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" name="telephone" id="telephone" value="' . ( isset( $_POST['telephone']) ? $telephone : null ) . '">
            </div>
        </div>

        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4"  for="dob">Date of birth</LABEL>
            <div class="col-md-6 col-xs-6">
              <INPUT class="form-control  required input-details" id="dob" type="text" name="dob" value="' . ( isset( $_POST['dob']) ? $telephone : null ) . '" />
              </div>
            </div>

        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="studentnr">Student registration nr.</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" name="studentnr" id="studentnr" value="' . ( isset( $_POST['studentnr']) ? $studentnr : null ) . '">
            </div>
        </div>
        
        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="WBA_ID">WBA ID</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" name="WBA_ID" id="WBA_ID" value="' . ( isset( $_POST['WBA_ID']) ? $WBA_ID : null ) . '">
            </div>
        </div>

        <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="member_type">
              Type of member
            </LABEL>
            <div class="col-md-6 col-xs-6"><select id="member_type">
            <option>Student</option>
              <option>PHD</option>
              <option>Clubcard</option>
              <option>Trainer</option>
              <option>Employee</option>
            </select></div>
        </div>

  
         <div class="form-group">
              <LABEL class="control-label col-md-4 col-xs-4" for="veggie">
                Vegetarian
              </LABEL>
              <div class="col-md-6 col-xs-6"><INPUT  type="checkbox" name="veggie"  id="veggie" ' . ( (isset( $_POST['veggie']) && $_POST['veggie']=="on") ? "checked" : null ) . '  ></div>
          </div>

         <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="allergies">Food allergies</LABEL>
            <div class="col-md-6 col-xs-6"><textarea class="required form-control input-details" type="text" name="allergies" id="allergies" value="' . ( isset( $_POST['allergies']) ? $allergies : null ) . '"></textarea>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-info" value="Register" name="submit">
        </div>

    </form>
    ';
}

function registration_validation( $username, $password, $email, $website, $first_name, $last_name )  {

    global $reg_errors;
    $reg_errors = new WP_Error;
    if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    if ( 4 > strlen( $username ) ) {
        $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
    }
    if ( username_exists( $username ) ){
        $reg_errors->add('user_name', 'Sorry, that username already exists!');
    }
    if ( ! validate_username( $username ) ) {
        $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
    }
    if ( 5 > strlen( $password ) ) {
            $reg_errors->add( 'password', 'Password length must be greater than 5' );
        }
        if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
    }
    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', 'Email Already in use' );
    }
    if ( is_wp_error( $reg_errors ) ) {
     
        foreach ( $reg_errors->get_error_messages() as $error ) {
         
            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }
}

function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $address,$postal_code,$city,$telephone, $dob,$studentnr,$WBA_ID,$member_type,$allergies,$veggie;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'user_url'      =>   $website,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name
        );
        $user = wp_insert_user( $userdata );
        update_user_meta( $user , 'account_disabled', "on" );
        update_user_meta( $user , 'start_member', date('d-m-Y') );
        update_user_meta( $user , 'adress', $address);
        update_user_meta( $user , 'postal_code', $postal_code);
        update_user_meta( $user , 'city', $city);
        update_user_meta( $user , 'phone', $telephone);
        update_user_meta( $user , 'dob', $dob);
        update_user_meta( $user , 'studentnr', $studentnr);
        update_user_meta( $user , 'WBA_ID', $WBA_ID);
        update_user_meta( $user , 'member_type', $member_type);
        update_user_meta( $user , 'allergies', $allergies);
        update_user_meta( $user , 'veggie', $veggie);

        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
    }
}
function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['website'],
        $_POST['fname'],
        $_POST['lname']
        );
         
        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $address, $postal_code, $city, $telephone,$dob,$studentnr,$WBA_ID,$member_type,$allergies,$veggie;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $website    =   esc_url( $_POST['website'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        
        $address = sanitize_text_field( $_POST['address'] );
        $postal_code=sanitize_text_field( $_POST['postal_code'] );
        $city=sanitize_text_field( $_POST['city'] );
        $telephone=sanitize_text_field( $_POST['telephone'] );
        $dob=sanitize_text_field( $_POST['dob'] );
        $studentnr=sanitize_text_field( $_POST['studentnr'] );
        $WBA_ID=sanitize_text_field( $_POST['WBA_ID'] );
        $member_type=sanitize_text_field( $_POST['member_type'] );
        $allergies=sanitize_text_field( $_POST['allergies'] );
        $veggie= $_POST['veggie'] ;

        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $address,
        $postal_code,
        $city,
        $telephone,
        $dob,
        $studentnr,
        $WBA_ID,
        $member_type,
        $allergies,
        $veggie
        );
    }
 
    registration_form(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name
        );

     $headers = 'From: ' . get_bloginfo( "name" ) . ' <' .  "a.r.bakker1@gmail.com" . '>' . "\r\n";
    wp_mail( $email, 'You are being created, brah', 'Your account at ' . get_bloginfo("name") . ' is being created right now.', $headers );

}

// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );
 
// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}


?>
