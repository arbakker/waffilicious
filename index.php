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
 * @package minim2
 * @since minim2 1.0
 */

get_header(); ?>


<?php get_header(); ?>

<?php if(is_front_page() ) { ?>

<main class="container" role="main">
<section>
    <div class="row no-gutter pad-gutter">
<?php
	$args = array( 'numberposts' => '5', 'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-aside',
				'operator' => 'NOT IN'
			),
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-image',
 				'operator' => 'NOT IN'
			)
	) );
	$recent_posts = wp_get_recent_posts( $args );
  $count=0;
	foreach( $recent_posts as $recent ){
    $length= strlen( $recent["post_excerpt"]);
    if ($count===6){
      echo '</div><div class="row">';
      break;
    }elseif ($count===6){
      echo '</div><div class="row">';
      break;
    };
    if ($length===0){
      $excerpt=strip_shortcodes( $recent["post_content"] );
      $excerpt=wp_trim_words($excerpt  );
      }
    else{
      $excerpt=$recent["post_excerpt"];
    };
    $postID=$recent["ID"];
    if (has_post_thumbnail( $postID )){
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
    }
    echo '<div class="col-s-2">'.'<a class="divlink" href="' . get_permalink($recent["ID"]).'""'.'title="'
    .esc_attr(__($recent["ex"])).'">'. '<div class="card">'.'<h3>' .   ( __($recent["post_title"])).' </h3>'.
    '<div class=media><img src="'.$image[0].'"></div>'.'<p>'.( __($excerpt)).'</p></div></a></div> ';




    $count++;
	}
?>
<div class="col-s-2">
  <div class="card">
  <h3>Social Links</h3>
  <ul class="fa-ul">
    <li ><a href="http://www.waf.wur.nl/facebook"><i class="fa-li fa fa-facebook"></i>Facebook group</a></li>
    <li><i class="fa-li fa fa-facebook-square"></i>Facebook page</li>
    <li><i class="fa-li fa fa-rss"></i>RSS feed</li>
    <li><i class="fa-li fa fa-external-link-square"></i>NFB news</li>
  </ul>
</div>
</div>



</div>
</main>
    </div><!-- #primary .content-area -->
<?php } else { ?>
<h1>NO FRONTPAGE!</h1>
<?php } ?>

<?php get_footer(); ?>
