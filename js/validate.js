jQuery().ready(function() {

    jQuery("#post").validate();

    jQuery( "#excerpt" ).addClass("required");

    if (jQuery("#set-post-thumbnail").find('img').size() === 0) {
      jQuery ('<p class="error">Please set featured image for post. No image? Check <a target="_blank" href="http://imgur.com/search/score/all?q_type=png&q_all=dog">this</a> for some inspiration.</p>' ).insertAfter( '#set-post-thumbnail' );
    }


});
