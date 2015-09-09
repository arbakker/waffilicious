<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php
        $postID=get_the_ID();
        $thumbnail=get_the_post_thumbnail( $postID, 'large' );

        $thumbnail=str_replace( 'class="', 'class="img-rounded img-responsive  img-page ', $thumbnail );
      ?>
      <div class="row" itemscope itemtype="https://schema.org/WebPage">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <h1 itemprop="name">
                  <?php the_title(); ?>
                  <?php edit_post_link( __( '<i class="fa registration fa-edit fa-lg"></i>'), '<span class="edit-link">', '</span>' );?>
                </h1>
              </div>
            </div>

           <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 bottom1">
               <div class="">
                 <?php echo $thumbnail; ?>
                 <meta itemprop="image"content="<?php echo $url;?>" >
               </div>
           </div>

          <div  class="col-xs-12 col-sm-6 col-md-6 col-lg-6 arcticle">
            <p>
             <?php the_content(); ?>

               <div class="post-meta inline-flex">
                 <div class="label">
                   <time itemprop="dateModified" datetime="<?php echo the_modified_date("c");?>"><strong><?php echo the_modified_date();?></strong></time>
                 </div>
               </div>


           </p>
          </div>
      </div>
</article>
