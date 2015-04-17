<?php /*

Template Name: Members
*/

if (!is_user_logged_in()){
  $url=site_url();
  wp_redirect( $url);
  exit;
}

get_header();

global $wpdb;
$query = "SELECT ID, user_nicename from $wpdb->users ORDER BY user_nicename";
$author_ids = $wpdb->get_results($query);
?>
<div class="row">
  <div class="table-responsive">
  <table class="table table-members table-hover table-striped loggedin" >
    <thead>
   <tr>
       <th>Name</th>
       <th>Email address</th>
       <th>Address</th>
       <th>Telephone nr.</th>
   </tr>
   </thead>

    <tbody>

<?php
// Loop through each author
foreach($author_ids as $author){

  // Get user data
  $user_id=$author->ID;
  $curauth = get_userdata($user_id);

  // If user level is above 0 or login name is "admin", display profile

    $login= $curauth ->user_login;
    $email= $curauth ->user_email;
    $display_name= $curauth ->display_name;
    $adress=get_the_author_meta( 'adress',   $user_id  );
    $telephone=get_the_author_meta( 'phone',   $user_id  );
    ?>
    <tr>
      <td><?php if  (current_user_can('edit_user', $user_id )){
        $url=site_url()."/member/".$login."/";
        ?>
        <a href="<?php echo $url;?>"><?php echo $display_name; ?></a>
        <?php }else{
           echo $display_name;
        }
        ?>
      </td>
      <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
        <td><?php echo $adress; ?></td>
          <td><a href="tel:<?php echo $telephone; ?>"><?php echo $telephone; ?></a></td>
    </tr>

    <?php

  }
?>
</tbody>
</table>
</div>
</div>
</main>
<?php
get_footer();

?>
