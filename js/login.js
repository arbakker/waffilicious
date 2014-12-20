// script file
// TODO: Check to load this file only on the login page

jQuery().ready(function() {

$('#logout').click(function() {
    var data = {
        'action'    : 'logout'
    };
    var alert_logout= '<div class="alert  alert-success fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>You are now logged out!</div>';
    $.ajax({
        url: ajaxurl, // your ajax url
        type: 'POST',
        dataType: 'json',
        data: data,
        error: function(jqXHR, textStatus, errorThrown) {  $('.login-message').html('There was an unexpected error');},
        success: function(data) {
          $( "main" ).prepend(alert_logout );
          $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
          $("#menu-loggedin").toggle();
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
        var alert= '<div class="alert  alert-success fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Welcome %DISPLAY_NAME%</div>';
        var alert_info= '<div class="alert  alert-info fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>%MESSAGE%</div>';
        var alert_error = '<div class="alert  alert-error fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>You are not logged in, there was an unexpected error</div>';

        $.ajax({
            url: ajaxurl, // your ajax url
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function(jqXHR, settings) { $('.login-message').html(''); },
            error: function(jqXHR, textStatus, errorThrown) {  $(alert_error).insertAfter(".login-message");},
            success: function(data) {
                if ( data.success !== true){
                  var req_message = alert_info.replace("%MESSAGE%", data.message);
                  $(req_message).insertAfter(".login-message");
                  return;
                }
                // reload on success
                var display_name=data.display_name;
                var user_login=data.user_login;
                var success_message = alert.replace("%DISPLAY_NAME%", display_name);
                $(success_message).insertAfter(".login-message");
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
