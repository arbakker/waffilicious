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
    add_image_size( 'single-image', 568, 378, false );

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
$link = str_replace( 'post-edit-link', 'post-edit-link btn btn-default', $link);
return $link;
}


 if ( ! function_exists( 'waf_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Shape 1.0
 */
function waf_posted_on() {
    printf( __( 'Posted on <time class="entry-date" datetime="%1$s" pubdate>%2$s</time><span class="byline"> by <span class="author vcard">%3$s</span></span>', 'minim2' ),
        esc_attr( get_the_time() ),
        esc_html( get_the_date() ),
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
        if (count($terms)==$counter)
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
        . $term->name .
        "</a>";
        $counter=$counter+1;
      $out[] = "";
    }
  }
  }
  return implode('', $out );
}

function custom_taxonomies_term(){
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
      foreach ( $terms as $term ) {
        $out[] = $term->name;
        break;
    }
  }
  }
  return implode('', $out );
}



function breezer_addDivToImage( $content ) {
   // A regular expression of what to look for.
   $pattern = '/(<img([^>]*)>)/i';
   // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
   $replacement = '<div class="img-responsive">$1</div>';
   $pattern2 = '/(align*)/i';
   $content=preg_replace($pattern2, "", $content);
   // run preg_replace() on the $content
   $content = preg_replace( $pattern, $replacement, $content );
   // return the processed content
   return $content;
}

add_filter( 'the_content', 'breezer_addDivToImage' );

/* Kill attachment, search, author, daily archive pages */
add_action('template_redirect', 'bwp_template_redirect');
function bwp_template_redirect()
{
	global $wp_query, $post;

	if ( is_attachment() || is_day() || is_search())
	{
		$wp_query->set_404();
	}

	if (is_feed())
	{
		$author 	= get_query_var('author_name');
		$attachment = get_query_var('attachment');
		$attachment = (empty($attachment)) ? get_query_var('attachment_id') : $attachment;
		$day		= get_query_var('day');
		$search		= get_query_var('s');

		if (!empty($author) || !empty($attachment) || !empty($day) || !empty($search))
		{
			$wp_query->set_404();
			$wp_query->is_feed = false;
		}
	}
}

function change_author_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'member';
    $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base. '/%author%';
}
add_action('init','change_author_permalinks');



function news_pagination($page, $max_num, $the_query){

  $older= explode('"', get_next_posts_link( 'Older Entries', $the_query->max_num_pages ))[1];
  $newer= explode('"', get_previous_posts_link( 'Newer Entries' ))[1];

  $url=get_site_url()."/news/page/";
  if ($page==0){
    $page++;
  }
  if ($page==1){
    echo '<ul class="pagination"><li class="disabled"><a href="'. $newer.'">&lt;</a></li>';
  }else{
    echo '<ul class="pagination"><li ><a href="'. $newer.'">&lt;</a></li>';
  }
  $lower=$page-2;
  $upper=$page+2;

  if ($lower<1){
    $lower=1;
    $upper=5;
  }
  if ($upper>$max_num){
    $upper=$max_num;
    $lower=$upper-4;
  }

  for ($x=$lower; $x<=$upper ; $x++) {
    if ($page==$x){
      echo  '<li class="active"><a href="'.$url.$x.'">'. $x.'</a></li>';
    }else{
    echo  '<li><a href="'.$url.$x.'">'. $x.'</a></li>';
  }
  }
  if ($page==$max_num){
    echo '<li class="disabled" ><a href="'. $older.'">&gt;</a></li></ul> ';
  }else{
    echo '<li><a href="'. $older.'">&gt;</a></li></ul> ';
  }
}


function st_pagination($page, $max_num, $the_query){

  $older= explode('"', get_next_posts_link( 'Older Entries', $the_query->max_num_pages ))[1];
  $newer= explode('"', get_previous_posts_link( 'Newer Entries' ))[1];

  $url=get_site_url()."/selected-talks/page/";
  if ($page==0){
    $page++;
  }
  if ($page==1){
    echo '<ul class="pagination"><li class="disabled"><a href="'. $newer.'">&lt;</a></li>';
  }else{
    echo '<ul class="pagination"><li ><a href="'. $newer.'">&lt;</a></li>';
  }
  $lower=$page-2;
  $upper=$page+2;

  if ($lower<1){
    $lower=1;
    $upper=5;
  }
  if ($upper>$max_num){
    $upper=$max_num;
    $lower=$upper-4;
  }

  if ($max_num>4){
  for ($x=$lower; $x<=$upper ; $x++) {
    if ($page==$x){
      echo  '<li class="active"><a href="'.$url.$x.'">'. $x.'</a></li>';
    }else{
    echo  '<li><a href="'.$url.$x.'">'. $x.'</a></li>';
  }
  }
  }
  if ($page==$max_num){
    echo '<li class="disabled" ><a href="'. $older.'">&gt;</a></li></ul> ';
  }else{
    echo '<li><a href="'. $older.'">&gt;</a></li></ul> ';
  }
}


if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'Widgetized Area',
		'id'   => 'widgetized-area',
		'description'   => 'This is a widget area on the single news item page.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
}

if (function_exists('register_sidebar')) {
register_sidebar(array(
  'name' => 'Widgetized Area 2',
  'id'   => 'widgetized-area2',
  'description'   => 'This is a widget area on the single news item page.',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h4>',
  'after_title'   => '</h4>'
));
}

add_action( 'admin_footer', 'catlist2radio' );
function catlist2radio(){
  echo '<script type="text/javascript">';
  echo 'jQuery("#categorychecklist input, #categorychecklist-pop input, .cat-checklist input, #event_categorieschecklist input")';
  echo '.each(function(){this.type="radio"});jQuery("#in-event_categories-3").attr("checked","checked");</script>';

}

function curPageURL() {
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  return $pageURL;
}

add_action('wp_head', 'addBackPostFeed');
function addBackPostFeed() {
  echo '<link rel="alternate" type="application/rss+xml" title="WAF RSS Feed" href="'.get_bloginfo('rss2_url').'" />';
}

function getFeed($feed_url, $items) {
    $count=0;
    $content = file_get_contents($feed_url);

    if ($content){
      $x = new SimpleXmlElement($content);

      echo "<ul style='list-style:none;padding-left:0px;'>";

      foreach($x->channel->item as $entry) {
          if ($count<$items){
          echo "<li ><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
          $count++;
        }
      }
      echo "</ul>";
  }else{
    ?>
    <p class="break-all">Could not load RSS feed from <a href="<?php echo $feed_url;?>"><?php echo $feed_url;?></a></p>
    <?php
  }
}

function myFeedFilter($query)
{
        // Check if we are requesting a feed.
        if ($query->is_feed)
        {
                // If a Feed do we have the post_type URL parameter (query_string)?
                if (isset($_GET['post_type']))
                {
                        // Convert the post_type URL parameter to an array. Then set the query post_type value to that array
                        $post_types = explode(',', $_GET['post_type']);
                        //var_dump($post_types);
                        $query->set('post_type', $post_types);
                }
        }
        return $query;
}
add_filter('pre_get_posts','myFeedFilter');

function div_wrapper($content) {
    // match any iframes
    $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // wrap matched iframe with div
        $wrappedframe = '<div class="embed-responsive embed-responsive-16by9">' . $match . '</div>';

        //replace original iframe with new in content
        $content = str_replace($match, $wrappedframe, $content);
    }

    return $content;
}
add_filter('the_content', 'div_wrapper');

function add_responsive_class($content){

        $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML(utf8_decode($content));

        $imgs = $document->getElementsByTagName('img');
        foreach ($imgs as $img) {
           $img->setAttribute('class','img-responsive');
        }

        $html = $document->saveHTML();
        return $html;
}
add_filter        ('the_content', 'add_responsive_class');



// custom admin login logo
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('template_directory').'/img/forgot-password.png) !important;height: 200px !important;width: 200px !important;background-size: 200px !important; }
  .wp-core-ui .button-primary{background:#0C9AF7 !important;}
  .login .message{  border-left: 4px solid #0C9AF7 !important; }
  input[type=checkbox]:checked:before {color:#0C9AF7 !important};
	</style>';
}
add_action('login_head', 'custom_login_logo');


function catch_that_image($postid) {
  $post = get_post($postid);
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  if(empty($first_img)) {
    $first_img = get_bloginfo('template_directory').'/img/default.png';
  }
  return $first_img;
}

function get_page_by_name($pagename)
{

$pages = get_pages();
foreach ($pages as $page) {
  if ($page->post_name == $pagename) return $page;
}
return false;
}

function remove_shortcode_from_index( $content ) {
  $content = strip_shortcode( "ninja_form" ,$content );
  return $content;
}

function strip_shortcode($code, $content)
{
    global $shortcode_tags;

    $stack = $shortcode_tags;
    $shortcode_tags = array($code => 1);

    $content = strip_shortcodes($content);

    $shortcode_tags = $stack;
    return $content;
}


?>
