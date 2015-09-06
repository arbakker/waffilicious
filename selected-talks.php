<?php
/**
 * Template Name: Selected-talks page
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php
get_header();

    $st_args=array(
    'post_type' => 'selected-talks',
    'post_status' => 'publish',
    'posts_per_page' => 5,

    );
    $my_st_query = null;
    $my_st_query = new WP_Query($st_args);

$st_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
// the query
$the_st_query = new WP_Query( 'posts_per_page=5&post_type=selected-talks&paged=' . $st_paged );

echo '<div class="list-group">';
if( $the_st_query->have_posts() ) {

  $i = 0;

  while ($the_st_query->have_posts()) : $the_st_query->the_post();

  $ID=$post->ID;
  $time=get_the_date();
  ?>


  <a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>" class="list-group-item list-group-news ">
  <span>
    <h4 class="list-group-item-heading"><?php  the_title();?></h4>
    <p class="list-group-item-text"><?php echo "";?></p>
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
$max_num = $the_st_query->max_num_pages;
st_pagination($page, $max_num, $the_st_query);


}
echo "</ul>";

wp_reset_query();
echo "</div>";

?>

<?php get_footer(); ?>
