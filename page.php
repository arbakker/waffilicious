<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header(); ?>
 <div class="row"
<?php
if (is_page("contact")){
  echo 'itemscope itemtype="https://schema.org/ContactPage"';
}else{
  echo 'itemscope itemtype="https://schema.org/WebPage"';
}
 ?>
 >


   <div class="col-sm-12 col-md-12" >

  <?php while ( have_posts() ) : the_post(); ?>

     <?php get_template_part( 'content', 'page' ); ?>

 <?php endwhile; // end of the loop. ?>

   </div>



 </div>
 </div>


<?php get_footer(); ?>
