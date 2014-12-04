jQuery().ready(function() {

    $("#save").click(function(){

      var displayname= $("#displayname").val();
      var email = $("#email").val();
      var password= $("#password").val();
      var telephone= $("#telephone").val();

      $.ajax({
        type: "POST",
        url: PT_Ajax.ajaxurl,
        data: "action=updatememberdetails&member="+userid+"&memberNonce=" + PT_Ajax.memberNonce+"&displayname="+displayname+"&email="+email+"&password="+password+"&telephone="+telephone,
        success: function(data){
        }
      });
    });
});
