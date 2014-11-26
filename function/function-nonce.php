<?php

add_action( 'wp_ajax_ajax-inputtitleSubmit', 'myajax_inputtitleSubmit_func' );
add_action( 'wp_ajax_nopriv_ajax-inputtitleSubmit', 'myajax_inputtitleSubmit_func' );
function inputtitle_submit_scripts() {
  wp_enqueue_script( 'inputtitle_submit', get_template_directory_uri() . '/js/event_button.js', array( 'jquery' ));
  wp_localize_script( 'inputtitle_submit', 'PT_Ajax', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'nextNonce' => wp_create_nonce( 'myajax-next-nonce' )
    )
    );
}
?>
