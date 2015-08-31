<?php
/**
 * Template Name: Members only page
 *
 * Members only page, only logged in users can view this page.
 *
 */
?>
<?php
if( !is_user_logged_in() ) {
		wp_redirect('../401', 302);
		exit;
	}
get_header();
?>

<div class="row">
 <div class="col-sm-12 col-md-12">

<?php while ( have_posts() ) : the_post(); ?>

   <?php get_template_part( 'content', 'page' ); ?>

<?php endwhile; // end of the loop. ?>

 </div>



</div>
</main>


<?php get_footer(); ?>
