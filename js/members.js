jQuery().ready(function() {

  jQuery( '#dob' ).datepicker({
    dateFormat: 'dd-mm-yy',
  });


  $("#savePassword").click(function(e){


    if ($("#changePassword").valid()) {

      var userinfo = {};
      userinfo.password=$("#password-new").val();

      if ($("#password-new").val()===$("#password-new-rep").val()){
        e.preventDefault();
         var l = Ladda.create(this);
         l.start();

        var request="";
        var requestinfo={};
        for (var key in userinfo){
          if (userinfo[key]!==window[key])
            {
              request+="&"+key+"="+userinfo[key];
              requestinfo[key]=userinfo[key];
            }
          }
          $.ajax({
            type: "POST",
            url: Members.ajaxurl,
            data: "action=updatememberdetails&member="+currentMemberId+"&memberNonce=" + Members.memberNonce+request,
            success: function(data){
              if (data.success) {

                for (var key in requestinfo){
                  var html="";
                  if (requestinfo[key]==="true"){
                    html="Yes";
                  }else if(requestinfo[key]==="false"){
                    html="No";
                  }else{
                    html=requestinfo[key];
                  }
                  $("#"+key+"_display").html(html);
                }
                $('#success-message').html('Jay! You have succesfully updated your password.');
                $('#alert-success').fadeIn('slow');
                $("#modalPassword").modal('hide');


              }else{
                $('#error-message-password').html('Oops! Something went wrong updating your password: '+data.data.message);
                $('#alert-error-password').fadeIn('slow');
              }
            },
            error: function(){
              $('#error-message-password').html('Server connection error: could not change password, please try again later.');
              $('#alert-error-password').fadeIn('slow');
            }

          }).always(function(){
             l.stop();
             });

      }else{
        $('#error-message-password').html("New passwords do not match, please fill in the same password twice.");
        $('#alert-error-password').fadeIn('slow');
      }



    }




  });



  $("#saveEmail").click(function(e){

    var userinfo = {};
    userinfo.email=$("#email").val();
    if ($("#changeEmail").valid()) {
      if ($("#email").val()===$("#email-rep").val()){
        e.preventDefault();
         var l = Ladda.create(this);
         l.start();
        var request="";
        var requestinfo={};
        for (var key in userinfo){
          if (userinfo[key]!==window[key])
            {
              request+="&"+key+"="+userinfo[key];
              requestinfo[key]=userinfo[key];
            }
          }
          $.ajax({
            type: "POST",
            url: Members.ajaxurl,
            data: "action=updatememberdetails&member="+currentMemberId+"&memberNonce=" + Members.memberNonce+request,
            success: function(data){
              if (data.success) {

                for (var key in requestinfo){
                  var html="";
                  if (requestinfo[key]==="true"){
                    html="Yes";
                  }else if(requestinfo[key]==="false"){
                    html="No";
                  }else{
                    html=requestinfo[key];
                  }
                  $("#"+key+"_display").html(html);
                }
                $('#success-message').html('Jay! You have succesfully changed your email address.');
                $('#alert-success').fadeIn('slow');
                $("#modalEmail").modal('hide');


              }else{
                $('#warning-message-email').html('Oops! Something went wrong changing your email address: '+data.data.message);
                $('#alert-warning-email').fadeIn('slow');

              }
            },
            error: function(){
              $('#warning-message-email').html('Server connection error: could not change email address, please try again later.');
              $('#alert-warning-email').fadeIn('slow');
            }
          }).always(function(){
             l.stop();
             });
      }else{

        $('#warning-message-email').html("Email adresses do not match, please fill in the same email address twice.");
        $('#alert-warning-email').fadeIn('slow');
      }



    }

  });


    $("#save").click(function(e){


      var userinfo = {};
      //a['name'] = 'oscar';
      userinfo.displayname= $("#displayname").val();
      userinfo.telephone= $("#telephone").val();
      userinfo.veggie=$("#veggie").is(":checked").toString()  ;
      userinfo.adress= $("#adress").val();
      userinfo.WBA_ID= $("#WBA_ID").val();
      userinfo.studentnr= $("#studentnr").val();
      userinfo.allergies= $("#allergies").val();
      userinfo.institute= $("#institute").val();
      userinfo.member_type= $("#member_type").val();
      userinfo.dob= $("#dob").val();

      if ($(".input-details").valid()) {
      e.preventDefault();
      var l = Ladda.create(this);
      l.start();
      var request="";
      var requestinfo={};
      for (var key in userinfo){
        if (userinfo[key]!==window[key])
          {
            request+="&"+key+"="+encodeURIComponent(userinfo[key]);
            requestinfo[key]=userinfo[key];
          }
      }
      $.ajax({
        type: "POST",
        url: Members.ajaxurl,
        data: "action=updatememberdetails&member="+currentMemberId+"&memberNonce=" + Members.memberNonce+request,
        success: function(data){
          if (data.success) {
            for (var key in requestinfo){
              var html="";
              if (requestinfo[key]==="true"){
                html="Yes";
              }else if(requestinfo[key]==="false"){
                html="No";
              }else{
                html=requestinfo[key];
              }
              $("#"+key+"_display").html(html);
            }
          $('#success-message').html('Jay! You have succesfully updated your user details.');
          $('#alert-success').fadeIn('slow');
          $("#myModal").modal('hide');
        }else{
          $('#warning-message-details').html('Oops! Something went wrong changing your user details: '+data.data.message);
          $('#alert-warning-details').fadeIn('slow');


        }
        },
        error: function(){
          $('#warning-message-details').html('Server connection error: could not update user details, please try again later.');
          $('#alert-warning-details').fadeIn('slow');
        }
      }).always(function(){
         l.stop();
         });

    }
    });
});
