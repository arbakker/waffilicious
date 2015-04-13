jQuery().ready(function() {

$('#logout').click(function() {
    var data = {
        'action'    : 'logout'
    };
    $.ajax({
        url: ajaxurl, // your ajax url
        type: 'POST',
        dataType: 'json',
        data: data,
        error: function(jqXHR, textStatus, errorThrown) {
          $('#danger-message-modal').html('Oops! There was an unexpected error while signing out.');
          $('#alert-danger-modal').fadeIn('slow');
          },
        success: function(data) {
          document.location.href="/";
        }
});
});

$('#signin').click(function(e) {
        var username=$('#username').val();
        e.preventDefault();
         var l = Ladda.create(this);
         l.start();
        var data = {
            'action'    : 'loginCheck',
            'username'  : $('#username').val(),
            'password'  : $('#password').val(),
            'rememberme': $('#rememberme').is( ':checked' ) ? true : false,
            'security'  : $('#security').val()
        };

        $.ajax({
            url: ajaxurl, // your ajax url
            type: 'POST',
            dataType: 'json',
            data: data,
            error: function(jqXHR, textStatus, errorThrown) {

              $('#danger-message-modal').html('Server connection error: could not sign in, please try again later.');
              $('#alert-danger-modal').fadeIn('slow');

               },
            success: function(data) {
                if ( data.success !== true){
                  $('#danger-message-modal').html(data.message);
                  $('#alert-danger-modal').fadeIn('slow');
                  return;
                }
                // reload on success
                location.reload ();
            }
    }).always(function(){
       l.stop();
       });
});
});
