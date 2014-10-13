<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Shape
 * @since Shape 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
      <?php
        $postID=get_the_ID();
        $thumbnail=get_the_post_thumbnail( $postID, 'medium' );
      ?>
      <div class="row">
        <div class="col-sm-4">
          <div class="media" >
            <?php echo $thumbnail; ?>
          </div>
        </div>
      <div class="col-md-8">

        <?php the_content(); ?>
        <?php //wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'minim2' ), 'after' => '</div>' ) ); ?>



      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
              <?php edit_post_link( __( '<i class="fa registration fa-edit fa-2x"></i>'), '<span class="edit-link">', '</span>' );?>
      </div>
    </div>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
