<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Shape
 * @since Shape 2.0
 */
?><!DOCTYPE html>

<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
/*
* Print the <title> tag based on what is being viewed.
*/
global $page, $paged;

wp_title( '|', true, 'right' );

// Add the blog name.
bloginfo( 'name' );

// Add the blog description for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
echo " | $site_description";

// Add a page number if necessary:
if ( $paged >= 2 || $page >= 2 )
echo ' | ' . sprintf( __( 'Page %s', 'minim2' ), max( $paged, $page ) );

?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.png" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body  <?php body_class(); ?>>

<!--onload="creator()"-->

<nav role="navigation" class="navbar">
        <div class="container">
            <div class="row">
                <a href="/" rel="home">WAF</a>
                <button data-dropdown-target="#navigation" class="visible-xs"><span class="visuallyhidden">Toggle Navigation</span></button>
                <div id="navigation" class="collapse">
                <?php
             $menuParameters = array(
              'container'       => false,
              'echo'            => false,
              'items_wrap'      => '%3$s',
              'depth'           => 0,
              'walker' => new Class_Name_Walker,
            );

            echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
            if ( is_user_logged_in() ) {
            global $current_user;
            get_currentuserinfo();
            echo "<a id='logout' href='javascript:void(0)'>Logout</a>";
            echo "<a href='javascript:void(0)' style='position:fixed;right:0px;font-size:0.7em;'>Welcome ".$current_user->user_login ."</a>";

            }


            ?>



                </div>
            </div>
        </div>
    </nav>

<?php if(is_front_page() ) { ?>
<div class="banner" style="height:300px;background-image:url('<?php header_image(); ?>');background-size:cover;background-repeat:no-repeat;background-position:50% 50%;"></div>
<?php } ?>
<div id="main" class="site-main">
