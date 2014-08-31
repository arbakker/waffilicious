<?php
/**
 * Template Name: Event page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>

<div class="row">
  <div class="col-s-12">
  <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'content', 'single' ); ?>

      <!--<div class="navigation"><p><?php posts_nav_link(); ?></p></div>-->

  <?php endwhile; // end of the loop. ?>

  </div>
</div>
</main>
<?php get_footer(); ?>
<?php
