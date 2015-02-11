<?php


$params = array(
  'ajaxurl' => admin_url('admin-ajax.php', $protocol),
  'ajax_nonce' => wp_create_nonce('any_value_here'),
);
wp_localize_script( 'my_blog_script', 'ajax_object', $params );



add_action('wp_ajax_updatemember', 'updatemember_ajax');

function updatemember_ajax() {

    $post_id = $_POST['id'];
    $members = get_post_meta($post_id, 'members', true);
    $member = intval($_POST['member']);

    $registered =is_user_registered ($member, $post_id) ;
    $message="";

    $members=waf_remove_member($member, $members);
    $members=waf_remove_empty($members);

    $result=update_post_meta($post_id,'members',$members);

    if ($result===true){
      $return = array(
      'message'	=> $message,
       );
      wp_send_json_success($return);
    }
    else{
      $return = array(
      'message'	=> $message,
      'members' => $members,
       );
      wp_send_json_error($return);
    }
}

?>
