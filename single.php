<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Shape
 * @since Shape 1.0
 */

get_header(); ?>
<main class="container" role="main">
<div class="row">
  <div class="col-s-12">
  <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'content', 'single' ); ?>

      <div class="navigation"><p><?php posts_nav_link(); ?></p></div>

  <?php endwhile; // end of the loop. ?>

  </div>
</div>

<?php get_footer(); ?>
