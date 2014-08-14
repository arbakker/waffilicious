<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Shape
 * @since Shape 1.0
 */

get_header(); ?>
 <main class="container" role="main">
 <div class="row">
   <div class="col-s-12">
     <div class="card">
  <?php while ( have_posts() ) : the_post(); ?>

     <?php get_template_part( 'content', 'page' ); ?>

 <?php endwhile; // end of the loop. ?>
</div>
   </div>
 </div>


<?php get_footer(); ?>
