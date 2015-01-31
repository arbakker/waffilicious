jQuery().ready(function() {

  jQuery( '#dob' ).datepicker({
    dateFormat: 'dd-mm-yy',
  });


  $("#savePassword").click(function(){


    if ($("#changePassword").valid()) {

      var userinfo = {};
      userinfo.password=$("#password-new").val();

      if ($("#password-new").val()===$("#password-new-rep").val()){
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
                $('#success-message').html('Jay! You have succesfully updated your user details.');
                $('#alert-success').fadeIn('slow');
                $("#modalPassword").modal('hide');


              }else{
                $('#danger-message').html('Oops! Something went wrong updating your user details, please try again later.')
                $('#alert-danger').fadeIn('slow');
                //alert(data.data.message);
              }
            },
            error: function(){
              $('#danger-message').html('Server connection error: could not change email address, please try again later.')
              $('#alert-danger').fadeIn('slow');
            }
          });


      }else{
        $('#warning-message-password').html("New passwords do not match, please fill in the same password twice.")
        $('#alert-warning-password').fadeIn('slow');


      }



    }




  });



  $("#saveEmail").click(function(){
    var userinfo = {};
    userinfo.email=$("#email").val();
    if ($("#changeEmail").valid()) {

      if ($("#email").val()===$("#email-rep").val()){
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
                $('#success-message').html('Jay! You have succesfully updated your user details.');
                $('#alert-success').fadeIn('slow');
                $("#modalEmail").modal('hide');


              }else{
                $('#danger-message').html('Oops! Something went wrong updating your user details, please try again later.')
                $('#alert-danger').fadeIn('slow');
                //alert(data.data.message);
              }
            },
            error: function(){
              $('#danger-message').html('Server connection error: could not change email address, please try again later.')
              $('#alert-danger').fadeIn('slow');
            }
          });
      }else{

        $('#warning-message-email').html("Email adresses do not match, please fill in the same email address twice.")
        $('#alert-warning-email').fadeIn('slow');
      }



    }

  });


    $("#save").click(function(){
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
          $('#success-message').html('Jay! You have succesfully updated your user details.');
          $('#alert-success').fadeIn('slow');
          $("#myModal").modal('hide');
        }else{
          $('#danger-message').html('Oops! Something went wrong updating your user details, please try again later.')
          $('#alert-danger').fadeIn('slow');
        }
        },
        error: function(){
          $('#danger-message').html('Server connection error: could not update user details, please try again later.');
          $('#alert-danger').fadeIn('slow');

        }
      });
    }
    });
});
