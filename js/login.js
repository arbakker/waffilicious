// script file
// TODO: Check to load this file only on the login page

jQuery().ready(function() {
var menu ="<ul class='nav navbar-nav navbar-right'><li><a id='login' class='menu-item menu-item-type-post_type menu-item-object-page' href='"+siteurl+"/sign-in' ><i class='fa registration fa-sign-in fa-lg'></i></a></li></ul>";

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
          $(".navbar-right").replaceWith(menu);
        }
});
});

$('button#Login').click(function() {
        var data = {
            'action'    : 'loginCheck',
            'username'  : $('#username').val(),
            'password'  : $('#password').val(),
            'rememberme': $('#rememberme').is( ':checked' ) ? true : false,
            'security'  : $('#security').val()
        };
        var alert= '<div class="alert  alert-success fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>You are now logged in</div>';
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
                if (typeof data.message !== 'undefined'){
                  var req_message = alert_info.replace("%MESSAGE%", data.message);
                  $(req_message).insertAfter(".login-message");
                  return;
                }
                // reload on success
                $(alert).insertAfter(".login-message");
                $("button.close").click(function()
                {
                  $("#dismiss").hide();
                });
                if (typeof data.success !== 'undefined' && data.success === true) {
                    //location.reload('');
                }
            }
    });
});
});
