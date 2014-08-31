
<?php
/**
 * Template Name: Login page
 *
 */
get_header();
?>

<div class="row">
<div class="col-s-12">
    <div class="card">
    <h3>Sign In</h3>
<?php
    //$args = array('redirect' => get_permalink( get_page( $page_id_of_member_area ) ) );
    //wp_login_form( $args );
?>
    <p class="login-message"></p>
    <fieldset>
    <div class="row">
    <div class="col-s-6">
    <div class="row">
                <div class="col-s-3">
                    <label for="username">Username</label>
                </div>
                <div class="col-s-6">
                    <input type="text" id="username">
                </div>
    </div>
    <div class="row">
                <div class="col-s-3">
                    <label for="password">Password</label>
                </div>
                <div class="col-s-6">
                    <input type="password" id="password">
                </div>
    </div>
    <div class="row">
        <div class="col-s-12">
            <input style="display:inline;" name="rememberme" type="checkbox" id="rememberme" value="forever">
            <label style="display:inline;" for="rememberme">Remember Me</label>
            <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
        </div>
    </div>
    <div class="row">
    <button id="Login" name="submit" value="Login">Login</button>
    </div>
    </div>
    <div class="col-s-3">
    </div>
</div>


</fieldset>
</div>
</div>
</div>
</main>
<?php
get_footer();

?>
