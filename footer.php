<?php
/**
* The template for displaying the footer.
*
* Contains the closing of the id=main div and all content after
*
*/
?>

</main><!-- #main .site-main -->
</div>




<footer id="footer" >
  <div class="container " role="content-info">

    <div class="row bottom">
      <div class="col-md-4 col-sm-4 col-xs-12 ">
        <a href="/" style="position:absolute:top:4em;">
          <?php echo '<?xml version="1.0" encoding="utf-8"?>';?>
          <?php include("img/waf_full_logo.svg"); ?>
        </a>


            <p style="text-align:center;left: -.4em;position: relative;top:-1.5em;">
            <a href="http://www.waf.wur.nl/facebook" data-toggle="tooltip" data-placement="left" title="WAF Facebook group" style="margin-left:0.3em;margin-right:0.3em;"><i class="fa fa-facebook fa-2x footer"></i></a>
            <a href="http://www.waf.wur.nl/facebook"  data-toggle="tooltip" data-placement="left" title="WAF Facebook page" style="margin-left:0.3em;margin-right:0.3em;"><i class=" fa fa-facebook-square fa-2x footer"></i></a>
            <a href="<?php bloginfo('atom_url');echo '?post_type=event,post'; ?>"><i class=" fa fa-rss fa-2x  footer"  data-toggle="tooltip" data-placement="left" title="WAF RSS feed" style="margin-left:0.3em;margin-right:0.3em;"></i></a>
            <a href="http://www.frisbeesport.nl"  data-toggle="tooltip" data-placement="left" title="Nederlandse Frisbee Bond" style="margin-left:0.3em;margin-right:0.3em;"><i class=" fa fa-external-link-square fa-2x footer"></i></a>
          </p>
        </div>
        <!--<img class="footer-logo" src="<?php echo get_template_directory_uri();?>/img/waf_full_logo.svg" alt="WAF Full Logo">-->


        <div class="col-md-4 col-sm-4 col-xs-12 ">
          <div style="display:block:margin-left:auto;margin-right:auto;">
  <h3>News</h3>
          <ul class="footer" >
          <?php
          $array=array('numberposts' => 5);
          $recent_posts = wp_get_recent_posts($array);
          foreach( $recent_posts as $recent ){
            echo '<li style="list-style:none;"><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
          }
          ?>
          </ul>

          <?php
          $array = array(
            'post_type' => 'event',
            'orderby' => 'meta_value_num',
            'meta_key' =>'event-sort-date',
            'order' => 'DESC',
            'numberposts' => 5
          );
          $recent_posts = wp_get_recent_posts($array);
          if (count($recent_posts)>0){
          ?>

          <?php //echo getFeed("http://www.frisbeesport.nl/web/index.php?option=com_content&view=section&layout=blog&id=1&format=feed&type=rss",5);?>

        </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div style="display:block;margin-left:auto;margin-right:auto;">


          <h3>Events</h3>
          <ul class="footer" >
          <?php

          foreach( $recent_posts as $recent ){
            echo '<li style="list-style:none;"><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
          }
          echo "</ul>";
          }
          ?>


        </div>
        </div>






      </div>



    </div>

<!--
<ul  class= "footer">

  <li><a href="http://www.waf.wur.nl/facebook" title="Facebook group WAF"><i class="fa fa-facebook  footer"></i>&nbsp;&nbsp;Facebook Group</a></li>
  <li><a href="http://www.waf.wur.nl/facebook" title="Facebook page WAF"><i class=" fa fa-facebook-square footer"></i>&nbsp;&nbsp;Facebook Page</a></li>
  <li><a href="#"><i class=" fa fa-rss  footer" title="RSS Feed WAF"></i>&nbsp;&nbsp;RSS Feed</a></li>
  <li><a href="http://www.frisbeesport.nl" title="Nederlandse Frisbee Bond"><i class=" fa fa-external-link-square footer"></i>&nbsp;&nbsp;Nederlandse Frisbee Bond</a></li>
</ul>
-->




  </div>
  <div class="row" style="margin:0px;">
    <div style='text-align:center;margin-bottom:1em;padding:0px;'class="col-md-12 col-sm-12 col-xs-12">
      <p class="inline details" >
      WAF is a Student Sport Association of the </p><p class="inline-block details"> <a href="http://www.wageningenur.nl/en/Wageningen-Campus/sports-centre-de-bongerd/SWU-Thymos.htm">Wageningen University</a> <img style="width:32px;"src="<?php echo get_template_directory_uri();?>/img/wur-logo.png" alt='WUR Logo'>
    </p>
    </div>
  </div>
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->
<?php wp_footer(); ?>
</body>
</html>
