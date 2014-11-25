
$(document).ready
        (
        function(){
    $("#next").click(function() {
      alert("Clicked!");
      $.post(
        PT_Ajax.ajaxurl, {
          // wp ajax action
          action: 'ajax-inputtitleSubmit',
          // vars
          title: $('input[name=title]').val(),
          // send the nonce along with the request
          nextNonce: PT_Ajax.nextNonce
        },
        function(response) {
          console.log(response);
        }
      );
      return false;
    });
});
