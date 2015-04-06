<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php
        $postID=get_the_ID();
        $thumbnail=get_the_post_thumbnail( $postID, 'large' );
        $thumbnail=str_replace( 'class="', 'class="img-thumbnail img-post ', $thumbnail );
      ?>
      <div class="row">
        <div class="col-sm-8 col-md-8 col-xs-12 bottomdot5">


          <div class="article">
            <h1>
              <?php the_title(); ?>
            </h1>

            <div class="bottom1">
              <?php echo $thumbnail; ?>
            </div>

            <?php

             the_content(); ?>
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
