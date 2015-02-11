<?php
/**
* The Sidebar containing the main widget areas.
*
* @package Shape
* @since Shape 1.0
*/
?>

<div class="row">
<div class="col-md-4">


</div>
<div class="col-md-4">
</div>
<div class="col-md-4">
  <div class="row" style="height:220px;">
    <a class="navbar-brand" href="/"><img src="<?php echo get_template_directory_uri();?>/img/WAF_FULL_OUTLINE.svg" style="height:200px;" alt="WAF Circular Logo"></a>
  </div>

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
