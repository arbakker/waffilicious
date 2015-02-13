<?php
/**
* The template for displaying the footer.
*
* Contains the closing of the id=main div and all content after
*
* @package Shape
* @since Shape 1.0
*/
?>

</main><!-- #main .site-main -->
</div>




<footer id="footer" >
  <div class="container " role="content-info">

    <div class="row bottom">
      <div class="col-md-4 col-sm-4 ">
        <h3>NFB News</h3>
        <?php echo getFeed("http://www.frisbeesport.nl/web/index.php?option=com_content&view=section&layout=blog&id=1&format=feed&type=rss",5);?>
      </div>

      <div class="col-md-4 col-sm-4">
        <h3>WAF News</h3>
        <ul class="footer" >
        <?php
        $array=array('numberposts' => 5);
        $recent_posts = wp_get_recent_posts($array);
        foreach( $recent_posts as $recent ){
          echo '<li style="list-style:none;"><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
        }
        ?>
      </ul>

      </div>
      <div class="col-md-4 col-sm-4  ">
        <h3>Links</h3>
        <ul  class= "footer">

          <li><a href="http://www.waf.wur.nl/facebook" title="Facebook group WAF"><i class="fa fa-facebook  footer"></i>&nbsp;&nbsp;Facebook Group</a></li>
          <li><a href="http://www.waf.wur.nl/facebook" title="Facebook page WAF"><i class=" fa fa-facebook-square footer"></i>&nbsp;&nbsp;Facebook Page</a></li>
          <li><a href="#"><i class=" fa fa-rss  footer" title="RSS Feed WAF"></i>&nbsp;&nbsp;RSS Feed</a></li>
          <li><a href="http://www.frisbeesport.nl" title="Nederlandse Frisbee Bond"><i class=" fa fa-external-link-square footer"></i>&nbsp;&nbsp;Nederlandse Frisbee Bond</a></li>
        </ul>

      </div>

    </div>






  </div>
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->
<?php wp_footer(); ?>
</body>
</html>
