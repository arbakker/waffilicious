<?php
/*
Template Name: Custom WordPress Password Reset
*/
?>
<?php
global $wpdb, $user_ID;
wp_enqueue_script( 'jquery' );

if (!$user_ID) { //block logged in users
   //Validation stuffs, Form stuffs, etc
}
else {
wp_redirect( home_url() ); exit;
  //redirect logged in users to home page
}
?>




<div id="content">
<h1><?php the_title(); ?></h1>
<div id="result"></div> <!-- To hold validation results -->
<form id="wp_pass_reset" action="" method="post">

<label>Username or E-mail</label><br />
<input type="text" name="user_input" value="" /><br />
<input type="hidden" name="action" value="tg_pwd_reset" />
<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
<input type="submit" id="submitbtn" name="submit" value="Reset" />

</form>
<script type="text/javascript">
jQuery("#wp_pass_reset").submit(function() {
	jQuery("#result").html("<span class='loading'>Validating...</span>").fadeIn();
	var input_data = jQuery("#wp_pass_reset").serialize();
	jQuery.ajax({
		type: "POST",
		url:  "'. get_permalink( $post->ID ).'",
		data: input_data,
		success: function(msg){
			jQuery(".loading").remove();
			jQuery("<div>").html(msg).appendTo("div#result").hide().fadeIn("slow");
		}
	});
	return false;
});
</script>
</div>

<? php

?>
