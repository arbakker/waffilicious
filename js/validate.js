jQuery().ready(function() {

  jQuery('form').submit(function(){

  //   if (jQuery("form#post").length > 0){
  //     if (jQuery("#set-post-thumbnail").find('img').size() === 0) {
  //       alert('Please set a featured image for this item.');
  //       return false;
  //     }else{
  //       return true;
  //     }
  // }
  });



    jQuery("#post").validate();


    if (jQuery("#set-post-thumbnail").find('img').size() === 0) {
      jQuery ('<p class="error">Please set featured image for post. No image? Check <a target="_blank" href="http://imgur.com/search/score/all?q_type=png&q_all=dog">this</a> for some inspiration.</p>' ).insertAfter( '#set-post-thumbnail' );
    }


});
