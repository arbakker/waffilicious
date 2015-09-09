<?php
/**
 * Template Name: Blog page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>

<?php

    $args=array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'caller_get_posts'=> 1
    );
    $my_query = null;
    $my_query = new WP_Query($args);

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
// the query
$the_query = new WP_Query( 'paged=' . $paged );


echo '<div class="list-group" itemscope itemtype="https://schema.org/CollectionPage">';
if( $the_query->have_posts() ) {

  $i = 0;

while ($the_query->have_posts()) : $the_query->the_post();

$image = get_the_post_thumbnail( $post->ID, 'thumbnail' );
$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' )[0];
if (!$url){
  $url =catch_that_image( $post->ID );
}

$urlLarge = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' )[0];
if (!$urlLarge){
  $urlLarge =catch_that_image( $post->ID );
}




$image='<img property="thumbnailUrl" src="'.$url.'" class="img-rounded img-responsive img-news attachment-thumbnail wp-post-image"  height="80" width="80">';


$ID=$post->ID;
$time=get_the_date();
$excerpt=get_the_excerpt();?>



<a span itemscope itemtype="http://schema.org/BlogPosting" href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>" class="list-group-item list-group-news ">
  <meta  itemprop="url" content"<?php the_permalink() ?>">
  <div class="image-news">
  <?php

    echo $image ;?>
    <meta itemprop="image"content="<?php echo $urlLarge;?>" >
</div>
<span>
  <h4 itemprop="headLine" class="list-group-item-heading"><?php  the_title();?></h4>
  <p class="list-group-item-text" itemprop="description"><?php echo $excerpt;?></p>
</span>
<div class="label posts">
  <time itemprop="datePublished" datetime="<?php echo get_the_date('c');?>"><strong><?php echo get_the_date( );?></strong></time>
</div>

</a>

<?php

    $i++;
endwhile;


?>



<?php

$page = get_query_var('paged');
$max_num = $the_query->max_num_pages;
news_pagination($page, $max_num, $the_query);


}
echo "</ul>";

wp_reset_query();
echo "</div>";

?>

<?php get_footer(); ?>
