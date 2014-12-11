jQuery().ready(function() {

  jQuery( '#dob' ).datepicker({
    dateFormat: 'dd-mm-yy',
  });

  //$('#alert_template.close').click(function(e) {
  //  $("#alert_template span").remove();
  //});

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


      if ($(".form-control").valid()) {





      var request="";
      var requestinfo={};
      for (var key in userinfo){
        // key & userinfo[key]
        //console.log(key);
        //console.log(userinfo[key]);
        //console.log(window[key]);

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
          //$("#alert_template button").after('<span>Jay! Succesfully updated your user details!</span>');
          $('#alert_template').fadeIn('slow');
          $("#myModal").modal('hide');
        }else{
          alert(data.data.message);

        }
        },
        error: function(){
          alert('Server connection error: could not update user details, please try again later.');
        }
      });
    }
    });
});
