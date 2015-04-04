<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php
        $postID=get_the_ID();
        $thumbnail=get_the_post_thumbnail( $postID, 'medium' );
        $thumbnail=str_replace( 'class="', 'class="img-thumbnail  img-page ', $thumbnail );
      ?>
      <div class="row">
        <div class="col-sm-4 col-md-4">
          <h1 class="single-page-title">
            <?php the_title(); ?>
            <?php edit_post_link( __( '<i class="fa registration fa-edit fa-lg"></i>'), '<span class="edit-link">', '</span>' );?>
          </h1>
            <?php echo $thumbnail; ?>
        </div>
      <div class="col-sm-8 col-md-8">
        <?php the_content(); ?>
      </div>
    </div>

</article>
