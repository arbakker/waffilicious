<?php
/**
* The Sidebar containing the main widget areas.
*
* @package Shape
* @since Shape 1.0
*/
?>
<div class="row">
<div class="col-md-12">

<ul   class= "list-inline">

  <li><a href="http://www.waf.wur.nl/facebook" title="Facebook group WAF"><i class="fa fa-facebook fa-3x footer"></i></a></li>
  <li><a href="http://www.waf.wur.nl/facebook" title="Facebook page WAF"><i class=" fa fa-facebook-square fa-3x footer"></i></a></li>
  <li><a href="#"><i class=" fa fa-rss fa-3x footer" title="RSS Feed WAF"></i></a></li>
  <li><a href="http://www.frisbeesport.nl" title="Nederlandse Frisbee Bond"><i class=" fa fa-external-link-square fa-3x footer"></i></a></li>
</ul>

</div>

</div>
<div class="row">
<div class="col-md-12">
  <p class="text-right footer">
    WAF - Wageningen Algemene Frisbee Club
  </p>
</div>
</div>



<?php /**
<div id="secondary" class="widget-area" role="complementary">
    <?php do_action( 'before_sidebar' ); ?>
    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

        <aside id="search" class="widget widget_search">
            <?php get_search_form(); ?>
        </aside>

        <aside id="archives" class="widget">
            <h1 class="widget-title"><?php _e( 'Archives', 'minim2' ); ?></h1>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </aside>

        <aside id="meta" class="widget">
            <h1 class="widget-title"><?php _e( 'Meta', 'minim2' ); ?></h1>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </aside>

    <?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->

<div id="tertiary" class="widget-area" role="supplementary">
     <?php dynamic_sidebar( 'sidebar-2' ); ?>
</div><!-- #tertiary .widget-area -->
**/
?>
