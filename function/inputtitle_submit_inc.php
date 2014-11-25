<?php
add_action( 'wp_enqueue_scripts', 'inputtitle_submit_scripts' );


function inputtitle_submit_scripts() {
wp_enqueue_script( 'inputtitle_submit', get_template_directory_uri() . '/js/inputtitle_submit.js', array( 'jquery' ));
wp_localize_script( 'inputtitle_submit', 'PT_Ajax', array(
'ajaxurl' => admin_url( 'admin-ajax.php' ),
'nextNonce' => wp_create_nonce( 'myajax-next-nonce' ))
);
}

add_action( 'wp_ajax_ajax-inputtitleSubmit', 'myajax_inputtitleSubmit_func' );
add_action( 'wp_ajax_nopriv_ajax-inputtitleSubmit', 'myajax_inputtitleSubmit_func' );
function myajax_inputtitleSubmit_func() {
// check nonce
$nonce = $_POST['nextNonce'];
if ( ! wp_verify_nonce( $nonce, 'myajax-next-nonce' ) )
die ( 'Busted!');
// generate the response
$response = json_encode( $_POST );
// response output
header( "Content-Type: application/json" );
echo $response;
// IMPORTANT: don't forget to "exit"
exit;
}
?>
