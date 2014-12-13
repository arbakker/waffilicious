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
wp_title( '', true );
// Add the site title for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) ){

echo $site_description;
}
elseif ( is_home() || is_front_page() )
{
  wp_title( '', true );
}
// Add a page number if necessary:
if ( $paged >= 2 || $page >= 2 ){
echo ' | ' . sprintf( __( 'Page %s', 'minim2' ), max( $paged, $page ) );
}
?></title>
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.png" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body  <?php body_class(); ?>>

<!--onload="creator()"-->

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><img src="<?php echo get_template_directory_uri();?>/img/waf.svg" style="height:35px;position:relative;top:-3px;" alt="Kiwi standing on oval"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">



                <?php
             $menuParameters = array(
              'container'       => false,
              'echo'            => false,
              'items_wrap'      => '%3$s',
              'depth'           => 0,
              'walker' => new Class_Name_Walker,
            );



            echo wp_nav_menu( $menuParameters ) ;
            echo "</ul>";
            if ( is_user_logged_in() ) {
              global $current_user;
              get_currentuserinfo();
              $link_user_page=$site_url."/member/".$current_user->user_login;
              echo "<ul class='nav navbar-nav navbar-right'>";
              echo "<li data-original-title='Sign out' data-toggle='tooltip' ></li>";
              echo "<li></li>";
              ?>
              <li class="dropdown">
                <!--<a href='". ."' id='welcome' class=''><i class='fa registration fa-paw fa'></i>&nbsp;&nbsp;".$current_user->user_login ."</a>-->

                <a href="#" class="menu-item menu-item-type-post_type menu-item-object-page dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class='fa registration fa-paw fa'></i>&nbsp;&nbsp; <?php echo $current_user->user_login; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu" >
                  <li><a href="<?php echo  $link_user_page;?>"><i class='fa fa-user ' ></i>&nbsp;&nbsp;&nbsp;  My account</a></li>
                  <li><a href="<?php echo site_url();?>/members/"><i class='fa fa-users ' ></i>&nbsp;&nbsp; Members list</a></li>
                  <li class="divider"></li>
                  <li  data-original-title='Sign out' data-toggle='tooltip'><a id='logout'  class='' href='#'><i class='fa fa-sign-out ' ></i>&nbsp;&nbsp; Sign out</a></li>
                </ul>
              </li>
              <?php

              echo "</ul>";


            }
            else{
              echo "<ul class='nav navbar-nav navbar-right'>";
              echo "<li data-original-title='Sign in' data-toggle='tooltip'><a id='login' class='menu-item menu-item-type-post_type menu-item-object-page' href='".site_url()."/sign-in' ><i class='fa registration fa-sign-in fa-lg'></i>&nbsp;&nbsp; Sign in</a></li>";


              echo "</ul>";
            }
            ?>

                </div>
            </div>
        </div>
    </nav>

<?php if(is_front_page() ) { ?>
<!--<div class="banner" style="height:300px;background-image:url('<?php header_image(); ?>');background-size:cover;background-repeat:no-repeat;background-position:50% 50%;"></div>-->
<div class="img-holder" data-image="<?php header_image(); ?>" data-width="6211" data-height="4862" data-extra-height="0" ></div>
<section>
<?php } ?>





<div class='bg'>
<main class="container" role="main">
