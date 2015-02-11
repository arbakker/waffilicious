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
      <div class="container ">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><img id="navbarLogo" src="<?php echo get_template_directory_uri();?>/img/waf.svg" alt="WAF Logo"></a>
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
              ?>
              <ul class='nav navbar-nav navbar-right'>
              <li id='modal-login' style='display:none;' data-original-title='Show modal' data-toggle='tooltip'><a  class='menu-item menu-item-type-post_type menu-item-object-page' data-target="#loginmodal" data-toggle="modal"  href="#" ><i class='fa registration fa-sign-in fa-lg'></i>&nbsp;&nbsp; Sign in</a></li>
              <li class="dropdown" id="menu-loggedin">
                <!--<a href='". ."' id='welcome' class=''><i class='fa registration fa-paw fa'></i>&nbsp;&nbsp;".$current_user->user_login ."</a>-->

                <a href="#" class="menu-item menu-item-type-post_type menu-item-object-page dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class='fa registration fa-paw fa'></i>&nbsp;&nbsp; <?php echo $current_user->user_login; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu" style="color:#0C9AF7 !important;">
                  <li><a href="<?php echo  $link_user_page;?>"><i class='fa fa-user ' ></i>&nbsp;&nbsp;&nbsp;  My account</a></li>
                  <li><a href="<?php echo site_url();?>/members/"><i class='fa fa-users ' ></i>&nbsp;&nbsp; Members list</a></li>
                  <li  data-original-title='Sign out' data-toggle='tooltip'><a id='logout'  class='' href='#'><i class='fa fa-sign-out ' ></i>&nbsp;&nbsp; Sign out</a></li>
                </ul>
              </li>
            </ul>
              <?php

            }
            else{
              $link_user_page=$site_url."/member/";
              ?>
              <ul class='nav navbar-nav navbar-right'>
              <li id='modal-login' data-original-title='Show modal' data-toggle='tooltip'><a class='menu-item menu-item-type-post_type menu-item-object-page' data-target="#loginmodal" data-toggle="modal"  href="#" ><i class='fa registration fa-sign-in fa-lg'></i>&nbsp;&nbsp; Sign in</a></li>
              <li style="display:none;" class="dropdown" id="menu-loggedin">
                <!--<a href='". ."' id='welcome' class=''><i class='fa registration fa-paw fa'></i>&nbsp;&nbsp;".$current_user->user_login ."</a>-->

                <a href="#" id="dropdown-button" class="menu-item menu-item-type-post_type menu-item-object-page dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"></a>
                <ul class="dropdown-menu" role="menu" style="color:#0C9AF7 !important;">
                  <li><a id="a-userpage" href="<?php echo  $link_user_page;?>"><i class='fa fa-user ' ></i>&nbsp;&nbsp;&nbsp;  My account</a></li>
                  <li><a href="<?php echo site_url();?>/members/"><i class='fa fa-users ' ></i>&nbsp;&nbsp; Members list</a></li>
                  <li class="divider"></li>
                  <li  data-original-title='Sign out' data-toggle='tooltip'><a id='logout'  class='' href='#'><i class='fa fa-sign-out ' ></i>&nbsp;&nbsp; Sign out</a></li>
                </ul>
              </li>
              </ul>
              <?php
            }
            ?>
                </div>
            </div>
        </div>
    </nav>
    <?php
    if (!is_user_logged_in()){
    ?>
    <div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="loginmodal"><img src="<?php echo get_template_directory_uri();?>/img/WAFblack.svg" style="height:35px;position:relative;top:-3px;margin-right:1em" alt="WAF Logo">Sign in with your WAF account</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="userdetails">
                <div class="form-group">
                  <LABEL class="control-label col-md-4 col-xs-4" for="username">Username</LABEL>
                  <div class="col-md-6 col-xs-6"><INPUT class="required form-control" type="text" id="username"></div>
                </div>
                <div class="form-group">
                    <LABEL class="control-label col-md-4 col-xs-4" for="password">Password</LABEL>
                    <div class="col-md-6 col-xs-6"><INPUT class="required form-control" type="password" id="password"></div>
                </div>
              <div class="form-group">
                <LABEL class="control-label col-md-4 col-xs-4 checkbox">Remember me</label>
                <div class="col-md-6 col-xs-6"><input type="checkbox" id="rememberme" value="remember-me"></div>
              </div>
              <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="signin" class="btn btn-primary" data-dismiss="modal">Sign in</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
  }
    ?>









<div class='bg'>
<main class="container" role="main">
<p class="login-message"></p>

<div class="alert alert-success" id="alert-success" style="display: none;">
  <button type="button" onclick="$('.alert').hide();" class="close" >
    <span aria-hidden="true">&times;</span>
    <span class="sr-only">Close</span>
  </button>
  <div id="success-message">
  </div>
</div>

<div class="alert alert-warning" id="alert-warning" style="display: none;">
  <button type="button" onclick="$('.alert').hide();" class="close" >
    <span aria-hidden="true">&times;</span>
    <span class="sr-only">Close</span>
  </button>
  <div id="warning-message">
  </div>
</div>


<div class="alert alert-danger" id="alert-danger" style="display: none;">
  <button type="button" onclick="$('.alert').hide();" class="close" >
    <span aria-hidden="true">&times;</span>
    <span class="sr-only">Close</span>
  </button>
  <div id="danger-message">
  </div>
</div>
