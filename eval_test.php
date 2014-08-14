function show_customfield(){
  $args=array(
    'post_type' => 'event',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    );
  $my_query = null;
  $my_query = new WP_Query($args);
  $events = "";

  if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) {
      $my_query->the_post();
      $title=get_the_title();
      $slug=basename(get_permalink());
      $user_ID = get_current_user_id();

      $profilefield="function profile_field_".$slug." ( \$user_ID ) {?><table class='form-table'><tr><th><label for='".$slug."'>Test</label></th><td><input type='checkbox' name='". $slug ."' id='". $slug ."' /></td><td>". esc_html($title) ."</<td><td>".esc_html($slug) ."</td></td></tr></table><?php};";

      $action1="add_action( 'show_user_profile', 'profile_field_".$slug."' );";
      $action2="add_action( 'edit_user_profile', 'profile_field_".$slug."' );";

      echo $action1."</br>";
      echo esc_html($profilefield)."</br>";

      eval($profilefield);
eval($action1);
eval($action2);
  }
  }
}
