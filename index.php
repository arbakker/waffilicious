<?php
/*
Template Name: Index
*/

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package waffilicious
 * @since waffilicious 1.0
 */

get_header(); ?>


<?php get_header(); ?>

<?php if(is_front_page() ) { ?>


<div class="row no-pad">
  <div class="col-md-6">
    <?php
    $args = array( 'numberposts' => '1', 'tax_query' =>
              array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => 'post-format-aside',
                'operator' => 'NOT IN'
              )
            ) ;
  $latest_post = wp_get_recent_posts( $args );
  foreach( $latest_post as $latest ){

    $postID=$latest["ID"];
    $title=$latest["post_title"];
    if (has_post_thumbnail( $postID )){
    $image = get_the_post_thumbnail( $postID, 'large' );
    $pattern="/.*(http:\/\/.*\.jpg).*/";
    preg_match($pattern,$image,$matches);
    $url=$matches[1];
    $length= strlen( $latest["post_excerpt"]);
    if ($length===0){
      $excerpt=strip_shortcodes( $latest["post_content"] );
      $excerpt=wp_trim_words($excerpt, $num_words = 35 );
    }
    else{
      $excerpt=$latest["post_excerpt"];
    };

    ?>
    <article class="caption">
      <div class="caption__media" style="background-image:url('<?php echo  $url;?>');background-size: cover;" />
        <div class="caption__gradient"/>
        <h3 class="label__overlay" >News</h3>
        <div class="caption__overlay">
          <a href="<?php echo get_permalink($latest["ID"]) ;?>"><h1 class="caption__overlay__title"><?php echo $title;?></h1></a>
          <p class="caption__overlay__content"> <?php echo $excerpt; ?></p>
        </div>
      </article>
      <?php
}

  }
    ?>



  </div>   <!-- class="col-md-6" -->
  <div class="col-md-6" >
    <?php
    $args_events = array(
      'numberposts' => 1,
      'post_type' => 'event',
      'order' => 'DESC',
      'post_status' =>'publish'
    ) ;
    $latest_event = wp_get_recent_posts( $args_events);


  foreach( $latest_event as $latest ){

    $postID=$latest["ID"];
    $title=$latest["post_title"];
    if (has_post_thumbnail( $postID )){
    $image = get_the_post_thumbnail( $postID, 'large' );
    $pattern="/.*(http:\/\/.*\.jpg).*/";
    preg_match($pattern,$image,$matches);
    $url=$matches[1];
    $length= strlen( $latest["post_excerpt"]);
    if ($length===0){
      $excerpt=strip_shortcodes( $latest["post_content"] );
      $excerpt=wp_trim_words($excerpt, $num_words = 35 );
    }
    else{
      $excerpt=$latest["post_excerpt"];
    };


    $postTypeUrl=get_site_url()."/events/";
    ?>



      <article class="caption">
        <div class="caption__media" style="background-image:url('<?php echo  $url;?>');background-size: cover;" />
        <div class="caption__gradient"/>
        <h3 class="label__overlay" >Events</h3>

        <div class="caption__overlay">
          <a href="<?php echo get_permalink($latest["ID"]) ;?>"><h1 class="caption__overlay__title"><?php echo $title;?></h1></a>
          <p class="caption__overlay__content"> <?php echo $excerpt; ?></p>
          <a href="<?php echo $postTypeUrl;?>" style="position:absolute;top:15em;right:1em;color:white"><h3>more events</h3></a>
        </div>
      </article>






    <?php

}

  }
  ?>



</div>   <!-- class="col-md-6" -->


</div>  <!-- class="row" -->



<!--<div class="row">
  <?php if ( is_active_sidebar( 'home_right_1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area col-md-12" role="complementary">
		<?php dynamic_sidebar( 'home_right_1' ); ?>
	</div>
	<?php endif; ?>
</div>-->
</main>
</div>
</section>

<?php } else { ?>
<h1>NO FRONTPAGE!</h1>
<?php } ?>

<?php get_footer(); ?>
