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
        error: function(jqXHR, textStatus, errorThrown) {  $('.login-message').html('There was an unexpected error');},
        success: function(data) {
                location.reload('');
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
        var alert= '<div id="dismiss" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss" >x</button><p>You are now logged in.</p></div>';
        $.ajax({
            url: ajaxurl, // your ajax url
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function(jqXHR, settings) { $('.login-message').html(''); },
            error: function(jqXHR, textStatus, errorThrown) {  $('.login-message').html('There was an unexpected error');},
            success: function(data) {
                if (typeof data.message !== 'undefined'){
                    $('.login-message').html(data.message);
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
