<?php
/*
Plugin Name: My Useful Widget
Plugin URI: http://mydomain.com
Description: My useful widget
Author: Me
Version: 1.0
Author URI: http://mydomain.com
*/

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');


  /**
   * Adds Foo_Widget widget.
   */
  class Foo_Widget extends WP_Widget {

  	/**
  	 * Register widget with WordPress.
  	 */
  	function __construct() {
  		parent::__construct(
  			'foo_widget', // Base ID
  			__( 'News Overview', 'text_domain' ), // Name
  			array( 'description' => __( 'Widget that shows the two news items before and after the current news item.', 'text_domain' ), ) // Args
  		);
  	}

  	/**
  	 * Front-end display of widget.
  	 *
  	 * @see WP_Widget::widget()
  	 *
  	 * @param array $args     Widget arguments.
  	 * @param array $instance Saved values from database.
  	 */
  	public function widget( $args, $instance ) {
  		echo $args['before_widget'];
      $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
      echo "<h3>". $title."</h3>";
      ?>

      <?php
      $stack = array();
      global $post;
      $post=get_post();
      $first_post=$post;

      $count_next=0;
      for ($i = 1; $i <= 2; $i++) {

        $post = get_next_post();
        if (!empty ($post)){
          setup_postdata( $post );
          array_push($stack, $post);
        }else{
          $count_next++;
        }
      }

      $post=$first_post;
      array_push($stack, $post);

      $count_prev=0;
      for ($i = 1; $i <= 2+$count_next; $i++) {
        $post = get_previous_post();
        if (!empty ($post)){
        setup_postdata( $post );
        array_push($stack, $post);
      }else{
        $count_prev++;
      }
      }
      $post=$first_post;
      for ($i = 1; $i <= 2+$count_prev; $i++) {

        $post = get_next_post();
        if (!empty ($post)){

          setup_postdata( $post );
          if ($i>2){
          array_unshift($stack,$post);
        }
      }}

      ?>


      <ul class="list-group">
        <?php



      $query = new WP_Query( array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 5,
        'posts_orderby'          => 'post_date',
        'order' => 'DESC',)
      );

      $posts = $query->get_posts();

      //var_dump($posts);
      foreach($stack as $post){


        $image = get_the_post_thumbnail( $post->ID, 'thumbnail' );
        $image= str_replace('class="','class="img-responsive img-rounded overflow-hidden ',$image);

				if ($first_post->ID==$post->ID){
					echo '<li class="list-group-item ">';
				}else{
					echo '<li class="list-group-item">';
				}

        echo '<a href="';
        echo get_permalink( $post->ID);
        echo '"><div class="row">';
        echo '<div class="col-md-3 col-xs-3">';
        echo $image;
        echo '</div><div class="col-md-9 col-xs-9">';
        echo $post->post_title;
        echo '</div></div></a>';
        echo '</li>';



      }



    ?>
  </ul>
    <?php


  		echo $args['after_widget'];
  	}

  	/**
  	 * Back-end widget form.
  	 *
  	 * @see WP_Widget::form()
  	 *
  	 * @param array $instance Previously saved values from database.
  	 */
  	public function form( $instance ) {
  		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
  		?>
  		<p>
  		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
  		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
  		</p>
  		<?php
  	}

  	/**
  	 * Sanitize widget form values as they are saved.
  	 *
  	 * @see WP_Widget::update()
  	 *
  	 * @param array $new_instance Values just sent to be saved.
  	 * @param array $old_instance Previously saved values from database.
  	 *
  	 * @return array Updated safe values to be saved.
  	 */
  	public function update( $new_instance, $old_instance ) {
  		$instance = array();
  		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

  		return $instance;
  	}

  } // class Foo_Widget

  // register Foo_Widget widget
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );


add_shortcode('wp_caption', 'MY_VERY_OWN_img_caption_shortcode');
add_shortcode('caption', 'MY_VERY_OWN_img_caption_shortcode');

/**
 * The Caption shortcode.
 *
 * Allows a plugin to replace the content that would otherwise be returned. The
 * filter is 'img_caption_shortcode' and passes an empty string, the attr
 * parameter and the content parameter values.
 *
 * The supported attributes for the shortcode are 'id', 'align', 'width', and
 * 'caption'.
 *
 * @since 2.6.0
 *
 * @param array $attr Attributes attributed to the shortcode.
 * @param string $content Optional. Shortcode content.
 * @return string
 */
function MY_VERY_OWN_img_caption_shortcode($attr, $content = null) {

	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int) $width) . 'px">'
	. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}


?>
