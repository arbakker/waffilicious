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


echo '<div class="list-group">';
if( $the_query->have_posts() ) {
    echo '';
    $page = get_query_var('paged');
    $max_num = $the_query->max_num_pages;
    news_pagination($page, $max_num, $the_query);

$i = 0;

while ($the_query->have_posts()) : $the_query->the_post();

$image = get_the_post_thumbnail( $post->ID, 'thumbnail' );
$image=str_replace( 'class="', 'class="img-rounded img-responsive img-news ', $image );
$ID=$post->ID;
$time=get_the_date();
$excerpt=get_the_excerpt();?>


<a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>" class="list-group-item list-group-news ">
  <?php
    echo $image ;?>

<span>
  <h4 class="list-group-item-heading"><?php  the_title();?></h4>
  <p class="list-group-item-text"><?php echo $excerpt;?></p>
</span>
<span class="badge">
<?php echo $time; ?>
</span>

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
