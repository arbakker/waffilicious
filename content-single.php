<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
      <h1 class="entry-title"><?php the_title(); ?></h1>


  </header><!-- .entry-header -->

  <div class="entry-content">
      <?php the_content(); ?>
      <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'minim2' ), 'after' => '</div>' ) ); ?>
  </div><!-- .entry-content -->


  <div class="entry-meta">

    <?php waf_posted_on(); ?>

    <?php

  echo " in " . custom_taxonomies_terms_links();

    ?>
    <?php edit_post_link( __( '<i class="fa registration fa-edit fa-2x"></i>'), '<span class="edit-link">', '</span>' ); ?>
  </div><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
