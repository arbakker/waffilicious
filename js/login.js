// script file
// TODO: Check to load this file only on the login page

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
          $('.login-message').html('There was an unexpected error');
          $('#danger-message').html('Oops! There was an unexpected error while signing out.');
          $('#alert-danger').fadeIn('slow');
          },
        success: function(data) {
          $('#success-message').html('You have now signed out!');
          $('#alert-success').fadeIn('slow');

          $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
          $("#menu-loggedin").toggle();
          $(".loggedin").hide();
          $("#modal-login").toggle();
        }
});
});

$('#signin').click(function() {
        var username=$('#username').val();
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

              $('#danger-message').html('Server connection error: could not sign in, please try again later.');
              $('#alert-danger').fadeIn('slow');

               },
            success: function(data) {
                if ( data.success !== true){
                  $('#danger-message').html('Oops! Something went wrong signing in, please try again later.');
                  $('#alert-danger').fadeIn('slow');
                  return;
                }
                // reload on success
                var display_name=data.display_name;
                var user_login=data.user_login;

                var menu_message='<i class="fa registration fa-paw fa"></i>&nbsp;&nbsp; %USER_LOGIN% <span class="caret"></span>';
                menu_message = menu_message.replace("%USER_LOGIN%", user_login);
                $("#dropdown-button").html(menu_message);
                $("#menu-loggedin").toggle();
                $("#modal-login").toggle();
                var link =$('#a-userpage').attr('href');
                $('#a-userpage').attr('href', link+username);

            }
    });
});
});
