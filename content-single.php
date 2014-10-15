<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php
        $postID=get_the_ID();
        $thumbnail=get_the_post_thumbnail( $postID, 'medium' );
        $thumbnail=str_replace( 'class="', 'class="img-thumbnail img-responsive img-post ', $thumbnail );
      ?>
      <div class="row">
        <div class="col-md-4 bottomdot5">
          <h1 class="single-post-h1">
          <?php the_title(); ?>
        </h1>
        <div class="entry-meta">
        <?php waf_posted_on(); ?>

        <?php



        ?>
        <?php edit_post_link( __( '&nbsp;<i class="fa registration fa-edit fa-lg"></i>'), '<span class="edit-link">', '</span>' ); ?>
      </div>

            <?php echo $thumbnail; ?>

        </div>
      <div class="col-md-8">

        <?php the_content(); ?>
        <?php //wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'minim2' ), 'after' => '</div>' ) ); ?>



      </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->




<!--

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
      <h1 class="entry-title"><?php the_title(); ?></h1>


  </header>

  <div class="entry-content">
      <?php the_content(); ?>
      <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'minim2' ), 'after' => '</div>' ) ); ?>
  </div>


  <div class="entry-meta">

    <?php waf_posted_on(); ?>

    <?php

  echo " in " . custom_taxonomies_terms_links();

    ?>
    <?php edit_post_link( __( '<i class="fa registration fa-edit fa-2x"></i>'), '<span class="edit-link">', '</span>' ); ?>
  </div>
</article><!-- #post-<?php the_ID(); ?> -->
