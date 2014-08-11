<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Shape
 * @since Shape 1.0
 */

get_header(); ?>

<main class="container" role="main">
<div class="row">
  <div class="col-s-12">
<?php if ( have_posts() ) : ?>

    <header class="page-header">
        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'minim2' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </header><!-- .page-header -->

    <?php /* Start the Loop */ ?>
    <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', 'search' ); ?>

    <?php endwhile; ?>

    <div class="navigation"><p><?php posts_nav_link(); ?></p></div>

<?php else : ?>

    <?php get_template_part( 'no-results', 'search' ); ?>

<?php endif; ?>
  </div>
</div>


<?php get_footer(); ?>
