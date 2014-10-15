
<?php
/**
 * Template Name: Sign in page
 *
 */
get_header();
?>
  <div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
      <p class="login-message"></p>
      <div class="account-wall">
        <h1 class="text-center login-title">Sign in with your WAF account</h1>
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
        <!--  <h3>Lose something?</h3>
			<p>Enter your username or email to reset your password.</p>

      <form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</div>
				<div class="login_fields">
					<?php do_action('login_form', 'resetpass'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit" tabindex="1002" />
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>-->



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
