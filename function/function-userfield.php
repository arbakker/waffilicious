<?php

add_action( 'show_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'personal_options_update', 'yoursite_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'yoursite_save_extra_user_profile_fields' );


function yoursite_extra_user_profile_fields( $user ) {
?>
  <h3><?php _e("Extra profile information", "blank"); ?></h3>
  <table class="form-table">
    <tr>
      <th><label for="phone"><?php _e("Phone"); ?></label></th>
      <td>
        <input type="text" name="phone" id="phone" class="regular-text"
            value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" /><br />
        <span class="description"><?php _e("Please enter your phone."); ?></span>
    </td>
    </tr>
  </table>
<?php
}

function yoursite_save_extra_user_profile_fields( $user_id ) {
  $saved = false;
  if ( current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, 'phone', $_POST['phone'] );
    $saved = true;
  }
  return true;
}

//add_action( 'show_user_profile', 'show_users' );
//add_action( 'edit_user_profile', 'show_users' );


function show_users ( $user ) {
  if ( current_user_can( 'manage_options' ) ) {
    /* A user with admin privileges */
  $string = "";
  $blogusers = get_users( 'blog_id=1&orderby=nicename' );
  // Array of WP_User objects.
  foreach ( $blogusers as $user ) {
    $string = $string . '<tr><td><span>' . esc_html( $user->user_email ) . '</span></td></tr>';
  }
  ?>
<table class="form-table">
  <tr><th>Users</th></tr>
  <?php echo $string; ?>
</table>
<?php
 }}

/*
function save_events( $user_id, $slug ) {
  echo "<h1>DETERING!!!!!!!!</h1>";
  if ( !current_user_can( 'edit_user', $user_id ) ){
    echo "CANNOT EDIT";
    return false;
  }
  $my_data = $_POST[$slug] ? on : off;
  echo "/" . $user_id ." / ". $slug." / " . $my_data . "<br/>";
  update_usermeta( $user_id, $slug, $my_data );
}

add_action( 'show_user_profile', 'show_customfield' );
add_action( 'edit_user_profile', 'show_customfield' );

//add_action('edit_user_profile_update' , 'show_customfield');

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
      $args=array($user_ID,$slug);
      echo $slug.' add_action<br/>';

      add_action( 'personal_options_update' , 'save_events', 10, $user_ID, $slug );
      add_action( 'edit_user_profile_update', 'save_events',10, $user_ID, $slug );

      $attends = get_user_meta( $user_ID, $slug, true);
      echo $attends."<br/>";
      if ( $attends == "" ) {
        $attends='<span class="fa fa-square"></span>';
      }
      else{
        if ($attends == true){
          $attends='<span class="fa fa-check-square"></span>';
        }
        else{
          $attends='<span class="fa fa-square"></span>';
        }
      }
      $checkbox = '<input type="checkbox" name="'. $slug .'" id="'. $slug .'" /><br />';
      $events = $events . '<tr><td>'.$checkbox .'</td><td>'. esc_html($title) .  "</<td><td>". esc_html($slug) ."</td>"."<td>". $attends ."</td>";
      }
    }
    ?>
  <table class="form-table">
    <tr><th>Events</th></tr>
    <?php echo $events; ?>
  </table>
  <?php
}
*/











?>
