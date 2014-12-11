
<?php
/**
 * Template Name: Login page
 *
 */
get_header();
?>
  <div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
      <p class="login-message"></p>
      <div class="account-wall">
        <h1 class="text-center login-title">Sign in to register for events</h1>
          <fieldset class="form-signin">
            <input type="text" class="form-control" id="username" placeholder="Username" required autofocus>
            <input type="password" class="form-control" id="password" placeholder="Password" required>
            <button class="btn btn-lg btn-default btn-block" id="Login" name="submit" value="Login">
              Sign in</button>
              <label class="checkbox pull-left">
                <input type="checkbox" id="rememberme" value="remember-me">Remember me
              </label>
              <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
          </fieldset>
<!--<a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>-->
      </div>
<!-- <a href="#" class="text-center new-account">Create an account </a> -->
    </div>
  </div>
</div>

</main>
<?php
get_footer();

?>
