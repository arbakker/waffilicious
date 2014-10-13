<?php

if ( ! function_exists( 'waffilicious_setup' ) ):
/*
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function waffilicious_setup() {
    /**
     * Make theme available for translation
     * Translations can be filed in the /languages/ directory
     * If you're building a theme based on waffilicious, use a find and replace
     * to change 'waffilicious' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'waffilicious', get_template_directory() . '/languages' );
    /**
     * Add default posts and comments RSS feed links to head
     */
    add_theme_support( 'automatic-feed-links' );
    /**
     * Enable support for the Aside Post Format
     */
    $args = array(
      'flex-width'    => true,
      'width'         => 2400,
      'flex-width'    => true,
      'height'        => 320,
      'default-image' => get_template_directory_uri() . '/img/header.jpg',
      'uploads'       => true,
    );
    add_theme_support( 'post-formats', array( 'aside' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-header', $args );
    //add_theme_support( 'custom-background', $args );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );

}
endif; // waffilicious_setup
add_action( 'after_setup_theme', 'waffilicious_setup' );

add_image_size( 'admin-list-thumb', 80, 80, true); //admin thumbnail


function my_add_excerpts_to_pages() {
add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'my_add_excerpts_to_pages' );

function custom_excerpt_length( $length ) {
  return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


add_filter( 'edit_post_link', 'edit_post_link_title_attribute' );
function edit_post_link_title_attribute( $link ) {
$type =  get_post_type( get_the_ID() );
$link = str_replace( '">', '" title="Edit this '.$type.'">', $link);
return $link;
}


 if ( ! function_exists( 'waf_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Shape 1.0
 */
function waf_posted_on() {
    printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'minim2' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'minim2' ), get_the_author() ) ),
        esc_html( get_the_author() )
    );
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since minim2 1.0
 */
function shape_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
        // Create an array of all the categories that are attached to posts
        $all_the_cool_cats = get_categories( array(
            'hide_empty' => 1,
        ) );

        // Count the number of categories that are attached to the posts
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'all_the_cool_cats', $all_the_cool_cats );
    }

    if ( '1' != $all_the_cool_cats ) {
        // This blog has more than 1 category so shape_categorized_blog should return true
        return true;
    } else {
        // This blog has only 1 category so shape_categorized_blog should return false
        return false;
    }
}

/**
 * Flush out the transients used in shape_categorized_blog
 *
 * @since Shape 1.0
 */
function shape_category_transient_flusher() {
    // Like, beat it. Dig?
    delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'shape_category_transient_flusher' );
add_action( 'save_post', 'shape_category_transient_flusher' );



if ( ! function_exists( 'shape_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Shape 1.0
 */
function shape_content_nav( $nav_id ) {
    global $wp_query, $post;

    // Don't print empty markup on single pages if there's nowhere to navigate.
    if ( is_single() ) {
        $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
        $next = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous )
            return;
    }

    // Don't print empty markup in archives if there's only one page.
    if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
        return;

    $nav_class = 'site-navigation paging-navigation';
    if ( is_single() )
        $nav_class = 'site-navigation post-navigation';

    ?>
    <div role="navigation" id="<?php echo $nav_id; ?>" >
    <?php if ( is_single() ) : // navigation links for single posts ?>
        <?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '<i class="fa registration fa-arrow-left fa-1x"></i>', 'Previous post link', 'waf' ) . '</span> %title' ); ?>
        <?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '<i class="fa registration fa-arrow-right fa-1x"></i>', 'Next post link', 'waf' ) . '</span>' ); ?>
    <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
        <?php if ( get_next_posts_link() ) : ?>
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'minim2' ) ); ?></div>
        <?php endif; ?>
        <?php if ( get_previous_posts_link() ) : ?>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'minim2' ) ); ?></div>
        <?php endif; ?>
    <?php endif; ?>

  </div><!-- #<?php echo $nav_id; ?> -->
    <?php
}
endif; // shape_content_nav


function custom_taxonomies_terms_links(){
  // get post by post id
  $post = get_post( $post->ID );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

    // get the terms related to post
    $terms = get_the_terms( $post->ID, $taxonomy_slug );

    if ( !empty( $terms ) ) {
      $out[] = "";
      $counter=0;
      foreach ( $terms as $term ) {
        if (count($terms) -1==$counter)
        {
          $out[] = " & ";
        }
        else{
          if ($counter>0){
            $out[] = ", ";
          }
        }
        $out[] =
          ' <a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
        .    $term->name
        . "</a>";
        $counter=$counter+1;

      $out[] = "";
    }
  }
  }
  return implode('', $out );
}

function breezer_addDivToImage( $content ) {
   // A regular expression of what to look for.
   $pattern = '/(<img([^>]*)>)/i';
   // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
   $replacement = '<div class="col-s-3"><div class="media">$1</div></div>';
   $pattern2 = '/(align*)/i';
   $content=preg_replace($pattern2, "", $content);
   // run preg_replace() on the $content
   $content = preg_replace( $pattern, $replacement, $content );
   // return the processed content
   return $content;
}

add_filter( 'the_content', 'breezer_addDivToImage' );









?>
