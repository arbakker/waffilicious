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

    <div class="row">
      <div class="col-md-6">
        <h1 >News and events</h1>
        <div class="list-group latest">
<?php
	$args = array( 'numberposts' => '2', 'tax_query' =>
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-aside',
				'operator' => 'NOT IN'
			)
	) ;
	$recent_posts = wp_get_recent_posts( $args );
  $args_events = array(
        'numberposts' => 2,
        'post_type' => 'event',
        'order' => 'DESC',
        'post_status' =>'publish'
  ) ;
  $recent_events = wp_get_recent_posts( $args_events);

  $recent_all=array_merge( $recent_posts, $recent_events);

  $count=0;
	foreach( $recent_all as $recent ){
    $length= strlen( $recent["post_excerpt"]);
    if ($length===0){
      $excerpt=strip_shortcodes( $recent["post_content"] );
      $excerpt=wp_trim_words($excerpt, $num_words = 35 );
      }
    else{
      $excerpt=$recent["post_excerpt"];
    };
    $postID=$recent["ID"];
    if (has_post_thumbnail( $postID )){
      $image = get_the_post_thumbnail( $postID, 'thumbnail' );
      //wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
    }
    if ($count>0){

    }
    ?>

<!--
<div class="list-group">
  <a href="#" class="list-group-item ">
    <h4 class="list-group-item-heading">List group item heading</h4>
    <p class="list-group-item-text">...</p>
  </a>
</div>
-->


      <a href="<?php echo get_permalink($recent["ID"]) ;?>" title="<?php echo esc_attr(__($recent["ex"])) ;?>" class="list-group-item ">
        <div class="media img-latest">
        <?php echo $image; ?>
        </div>
        <span class="badge"><?php
        if (get_post_type( $postID ) == "post"){
          echo "news";
        }else{
          echo get_post_type( $postID );
        }
         ?></span>
        <h4 class="list-group-item-heading"><?php  echo  __($recent["post_title"]) ;?></h4>
        <p class="list-group-item-text"><?php echo $excerpt;?></p>
      </a>








    <!--
  -->


    <?php


    //echo '<div class="row">'.'<a class="divlink" href="' . get_permalink($recent["ID"]).'""'.'title="'
    //.esc_attr(__($recent["ex"])).'">'. '<div class="card">'.'<h3>' .   ( __($recent["post_title"])).' </h3>'.
    //'<div style="width:100px;" class=media>'.$image.'</div>'.'<p>'.( __($excerpt)).'</p></div></a></div> ';
    $count++;
	}









?>
</div>
</div>
<div class="col-md-6">
  <h1>About WAF</h1>
  <?php $page = get_posts(
    array(
        'name'      => 'home',
        'post_type' => 'page'
    )
);
  $postid=$page[0]->ID;
  $thumbnail=get_the_post_thumbnail( $postID, 'large' );
  $thumbnail=str_replace( 'class="', 'class="img-rounded img-responsive ', $thumbnail );


if ( $page )
{
    echo $page[0]->post_content;
    echo $thumbnail;
} ?>

<!--  <div class="card">
  <h1>Social Links</h1>
  <ul class="fa-ul">
    <li ><a href="http://www.waf.wur.nl/facebook"><i class="fa-li fa fa-facebook"></i>Facebook group</a></li>
    <li><i class="fa-li fa fa-facebook-square"></i>Facebook page</li>
    <li><i class="fa-li fa fa-rss"></i>RSS feed</li>
    <li><i class="fa-li fa fa-external-link-square"></i>NFB news</li>
  </ul>
</div> -->
</div>



</div>
</main>
</div>
</section>

<?php } else { ?>
<h1>NO FRONTPAGE!</h1>
<?php } ?>

<?php get_footer(); ?>
