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
 */

get_header(); ?>


<?php get_header(); ?>

<?php if(is_front_page() ) { ?>

<div class="row no-pad">


  <!-- Show latest news item-->
  <div class="col-md-6 col-sm-6">
    <?php
    $args = array(
      'posts_per_page'   => 3,
      'orderby'          => 'post_date',
      'order'            => 'DESC',
      'post_type'        => 'post',
      'post_status'      => 'publish',
      'suppress_filters' => true );

    $latest_posts=get_posts( $args );

    $query = array(
      'post_type' => 'event',
      'orderby' => 'meta_value_num',
      'meta_key' =>'event-sort-date',
      'order' => 'ASC',
    );
    $events=array();
    $upcoming_event= wp_get_recent_posts($query);
    foreach( $upcoming_event as $upcoming ){
      $postID=$upcoming["ID"];
      if (get_post_field( 'event-start-date', $postID )>time()){
          array_push($events,$upcoming);
      }
    }

    function fancy_smancy_item($array,$index){
      $postID=$array[$index]->ID;
      $title=get_the_title( $postID );
      $image = get_the_post_thumbnail( $postID, 'large' );
      $pattern="/.*(http:\/\/.*\.(?:jpg|png)).*/";
      preg_match($pattern,$image,$matches);
      $url=$matches[1];
      $excerpt=strip_shortcodes($array[$index]->post_content );
      $excerpt=wp_trim_words($excerpt, $num_words = 35 );
      ?>

      <article class="caption">

        <div class="caption__media" style="background-image:url('<?php echo  $url;?>');background-size: cover;background-position:center;" />
          <div class="caption__gradient"/>
          <h3 class="label__overlay" ><?php echo "News" ;?></h3>

          <a class="tile-header" href="<?php echo get_permalink($postID) ;?>"><h1 class="h1-tile"><?php echo $title;?></h1></a>
          <a class="tile-header" href="<?php echo get_permalink($postID) ;?>">
          <div class="caption__overlay">

            <p class="caption__overlay__content"> <?php echo $excerpt; ?></p>
          </div>
        </a>
        </article>

    </div>   <!-- class="col-md-6" -->

      <?php
    }

    function fancy_smancy_page($object){
      $postID=$object->ID;
      $title=get_the_title( $postID );
      $image = get_the_post_thumbnail( $postID, 'large' );
      $pattern="/.*(http:\/\/.*\.(?:jpg|png)).*/";
      preg_match($pattern,$image,$matches);
      $url=$matches[1];
      $excerpt=strip_shortcodes($object->post_content );
      $excerpt=wp_trim_words($excerpt, $num_words = 35 );
      ?>
      <article class="caption">
        <div class="caption__media" style="background-image:url('<?php echo  $url;?>');background-size: cover;background-position:center;" />
          <div class="caption__gradient"/>
          <!--<h3 class="label__overlay" ><?php //echo "News" ;?></h3>-->
          <a class="tile-header" href="<?php echo get_permalink($postID) ;?>"><h1 class="h1-tile"><?php echo $title;?></h1></a>
          <a class="tile-header" href="<?php echo get_permalink($postID) ;?>">
          <div class="caption__overlay">

            <p class="caption__overlay__content"> <?php echo $excerpt; ?></p>
          </div>
        </a>
        </article>
    </div>   <!-- class="col-md-6" -->

    <?php
    }

    function fancy_smancy_event($array,$index){
      $postID=$array[$index]["ID"];
      $title=get_the_title( $postID );
      $image = get_the_post_thumbnail( $postID, 'large' );
      //echo $image;
      $pattern="/.*(http:\/\/.*\.(?:jpg|png)).*/";
      preg_match($pattern,$image,$matches);
      $url=$matches[1];
      $excerpt=strip_shortcodes($array[$index]["post_content"] );
      $excerpt=wp_trim_words($excerpt, $num_words = 35 );
      ?>
      <article class="caption">
        <div class="caption__media" style="background-image:url('<?php echo  $url;?>');background-size: cover;background-position:center;" />
          <div class="caption__gradient"/>
          <h3 class="label__overlay" ><?php echo  "Events";?></h3>
          <a class="tile-header" href="<?php echo get_permalink($postID) ;?>"><h1 class="h1-tile"><?php echo $title;?></h1></a>
          <a class="tile-header" href="<?php echo get_permalink($postID) ;?>">
          <div class="caption__overlay">

            <p class="caption__overlay__content"> <?php echo $excerpt; ?></p>
          </div>
        </a>
        </article>
    </div>   <!-- class="col-md-6" -->
      <?php
    }


    fancy_smancy_item($latest_posts,0);

    ?>


  <!-- Show upcoming event or second latest news item-->
<div class="col-md-6 col-sm-6" >
<?php

  if (count($events)<2){
  // Show second last news item
  fancy_smancy_item($latest_posts,1);
  }else{
  // Show upcoming event
  fancy_smancy_event($events,0);
  }

function sortFunction( $a, $b ) {
    return date($a["post_date"]) < date($b["post_date"]);
}

?>

</div>  <!-- class="row" -->
<div class="row no-pad">

  <!-- Show "waf_frontpagepage" or last added event or third last news item-->
  <div class="col-md-6 col-sm-6">
    <?php
    usort($events, "sortFunction");
    $option=get_option("waf_frontpagepage");
    if ($option=="0"){
      if (count($events)<1){
        fancy_smancy_item($latest_posts,2);
      }else{
        fancy_smancy_event($events,0);
      }
    }else{
      $page=get_post($option);
      fancy_smancy_page($page);
    }
     ?>
  <!-- Show "waf_frontpagepage2" or "Contact" page if not configured-->
  <div class="col-md-6 col-sm-6">
    <?php
    $option=get_option("waf_frontpagepage2");
    if ($option=="0"){
      $page = get_page_by_title( 'Contact' );
      fancy_smancy_page($page);
    }else{
      $page=get_post($option);
      fancy_smancy_page($page);
    }
    ?>
</div>

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
