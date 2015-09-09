<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php
        $postID=get_the_ID();

        $url = wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'large' )[0];
        if (!$url){
          $url =catch_that_image( $postID );
        }
        $thumbnail='<img property="thumbnailUrl" src="'.$url.'" class="img-rounded img-responsive img-news attachment-thumbnail wp-post-image" >';

      ?>
      <div class="row">
        <div class="col-sm-8 col-md-8 col-xs-12 bottomdot5" itemscope itemtype="http://schema.org/BlogPosting" >
          <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <h1 itemprop="headLine">
                  <?php the_title(); ?>
                </h1>
              </div>
            </div>
           <div class="col-sm-12 col-md-6 col-lg-6 bottom1">
               <div class="">
                 <?php echo $thumbnail; ?>
                 <meta itemprop="image"content="<?php echo $url;?>" >
               </div>
           </div>
          <div itemprop="articleBody" class="col-sm-12 col-md-6 col-lg-6">
             <?php the_content(); ?>
          </div>
        </div>
          <div class="top2">
            <div class="post-meta inline-flex">
              <div class="label">
                <time itemprop="datePublished" datetime="<?php echo get_the_date('c');?>"><strong><?php echo get_the_date( );?></strong></time>
              </div>

              <div class="label blue left1">
                <time itemprop="author" ><strong><?php echo " ";the_author(); ?></strong></time>
              </div>

            </div>
            <div class="inline-flex">
              <?php edit_post_link( __( '&nbsp;<i class="fa fa-edit"></i></i>'), '<span class="left1 ">', '</span>' ); ?>
            </div>
          </div>

        </div>
      <div class="col-sm-4  col-md-4 col-xs-12">
        <div class="row">
          <div class="col-sm-12  col-md-12 col-xs-12">
            <div id="widgetized-area">
            	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widgetized-area')) : else : ?>
            	<div class="pre-widget">
            		<p><strong>Widgetized Area</strong></p>
            		<p>This panel is active and ready for you to add some widgets via the WP Admin</p>
            	</div>
            	<?php endif; ?>
            </div>
          </div>
      </div>
      <div clas="row">
        <div class="col-sm-12  col-md-12 col-xs-12" style="padding:0px;">
          <div id="widgetized-area2">

            <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widgetized-area2')) : else : ?>
            <?php endif; ?>

          </div>
        </div>
      </div>

      </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
