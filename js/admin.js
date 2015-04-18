var users_arr = Admin.users;
jQuery().ready(function() {
    // Register remove button for each registered user
    jQuery(".user").each(function(){
      var id = jQuery(this).attr("id");
      var postid = jQuery("#add-members").attr('postid');
      jQuery("#unregister-" + id).click(function() {
        jQuery.ajax({
          type: "POST",
          url: Admin.ajaxurl,
          data: "action=removemember&id=" + postid + "&member=" + id + "&removememberNonce=" + Admin.removememberNonce,
          success: function(data) {
            if (data.success) {
              jQuery(".user-" + id).remove();
            } else {
              alert(data.data.message);
            }
          },
          error: function(){
            alert("Server connection error: could not remove member from event, please try again later.");
          }
        });
        });
        });

    // Set current date to start date of event and set mindate for enddate and maxdate for deadline
    jQuery( '#start-date' ).datepicker({
        dateFormat: 'dd MM yy',
        minDate: 0,
        onClose: function( selectedDate ){
          jQuery( '#end-date' ).datepicker( 'option', 'minDate', selectedDate);
          jQuery( '#end-date' ).datepicker('setDate', selectedDate);
          jQuery( '#deadline' ).datepicker( 'option', 'maxDate', selectedDate);
        }
    });
    jQuery( '#end-date' ).datepicker({
        dateFormat: 'dd MM yy',
        onClose: function( selectedDate ){
          jQuery( '#start-date' ).datepicker(  'option', 'maxDate', selectedDate);
        }
    });
    jQuery( '#deadline' ).datepicker({
        dateFormat: 'dd MM yy',
        minDate: 0,
        onClose: function( selectedDate ){
        }
    });
    // Call to make sure the Chosen dropdown list is activated
    jQuery(".chosen").chosen();

    // Register add members button
    jQuery("#add-members").click(function() {
      var postid = jQuery("#add-members").attr('postid');
      var members=jQuery("#select-members").val();
      var members_string ="";
      if (members!==null){
        members.forEach(function(entry){
        members_string+=entry+",";
      });
    }

      members_string = members_string.substring(0, members_string.length - 1);
      // Ajax request to add members
      if (members_string!==""){
      jQuery.ajax({
             type: "POST",
             url: Admin.ajaxurl,
             data: "action=addmembers&id="+postid+"&members="+members_string+"&addmembersNonce="+Admin.addmembersNonce,
             success: function(data){
               if (data.success){
               members.forEach(function(entry){
                var name="";
                var email="";
                var details="";
                if (users_arr[entry].name) {
                    name = users_arr[entry].name;
                }
                if (users_arr[entry].email){
                  email= users_arr[entry].email;
                }
                if (users_arr[entry].details){
                  details=users_arr[entry].details;
                }
                 var table_row="<tr class='user user-"+entry+"' id='"+entry+"'>\
                 <td style='border: 1px solid #999;padding: 0.5rem;'>"+name+"</td>\
                 <td style='border: 1px solid #999;padding: 0.5rem;'>"+email+"</td>\
                 <td style='border: 1px solid #999;padding: 0.5rem;'>"+details+"</td>\
                 <td style='border: 1px solid #999;padding: 0.5rem;'>"+'<i class="fa fa-question-circle"></i>'+"</td>\
                 <td style='border: 1px solid #999;padding: 0.5rem;' >"+"<button userid='"+entry+"' id='unregister-"+postid+"' style='height: 2.2em;width: 4em;' type='button'>X</button></td>\
                 </tr>";
                 jQuery(table_row).appendTo("#registered-members");
               });
              // Register remove button for just added members
              jQuery('#registered-members').on('click', 'button', function() {
                var userid=jQuery(this).attr("userid");
                jQuery.ajax({
                       type: "POST",
                       url: Admin.ajaxurl,
                       data: "action=removemember&id="+postid+"&member="+userid+"&removememberNonce="+Admin.removememberNonce,
                       success: function(data){
                         if (data.success){
                         jQuery(".user-"+userid).remove();
                       }else{
                         alert(data.data.message);
                       }
                       },
                       error: function(){
                         alert("Server connection error: could not remove member from event, please try again later.");
                       }
                     });
              });
            }else{
              alert(data.data.message);
            }
           },
           error: function(){
             alert("Server connection error: could not add member to event, please try again later.");
           }
           }
           );
         }

    });

    jQuery("#addGuest").click(function(event) {
      event.preventDefault();
      var postid = jQuery("#add-members").attr('postid');
      var guest_email=jQuery("#guest_email").val();
      var guest_player=jQuery("#guest_player").val();
      var guest_details=jQuery("#guest_details").val();
      var guest_veggie=jQuery('#guest_veggie').is(":checked");

      if (guest_player!==""){
      jQuery.ajax({
        type: "POST",
        url: Admin.ajaxurl,
        data: "action=addguest&id="+postid+"&guest_player="+guest_player+"&guest_email="+guest_email+"&guest_details="+guest_details+"&guest_veggie="+guest_veggie+"&addguestNonce="+Admin.addguestNonce,
        success: function(data){
          if (data.success){
            var id='_' + Math.random().toString(36).substr(2, 9);
            var icon;
            if (guest_veggie){
              icon='<i class="fa fa-check"></i>';
            }else{
              icon='<i class="fa fa-remove"></i>';
            }

            var row="<tr>\
            <td style='border: 1px solid #999;padding: 0.5rem;'>"+guest_player+"</td>\
            <td style='border: 1px solid #999;padding: 0.5rem;'>"+guest_email+"</td>\
            <td style='border: 1px solid #999;padding: 0.5rem;'>"+guest_details+"</td>\
            <td style='border: 1px solid #999;padding: 0.5rem;'>"+icon+"</td>\
            <td style='border: 1px solid #999;padding: 0.5rem;'><button id='"+id+"' style='height: 2.2em;width: 4em;' type='button' guest='"+guest_player+"'>X</button></td>\
            </tr>";
            var el= jQuery("button[guest="+guest_player+"]");
            if (el!==null){
              el.closest("tr").remove();
            }
            jQuery('#guestPlayers > tbody:last').append(row);

            jQuery("#"+id).click(function(event) {
              event.preventDefault();
              var postid = jQuery("#add-members").attr('postid');
              var guest_player = this.getAttribute("guest");
              var el =jQuery(this);
              jQuery.ajax({
                type: "POST",
                url: Admin.ajaxurl,
                data: "action=removeguest&id="+postid+"&guest_player="+guest_player+"&removeguestNonce="+Admin.removeguestNonce,
                success: function(data){
                  if (data.success){
                    el.closest("tr").remove();
                  } else{
                    alert(data.data.message);
                  }},
                  error: function(){
                    alert("Server connection error: could not remove member from event, please try again later.");
                  }
                });
              });

          } else{
            alert(data.data.message);
          }},
          error: function(){
            alert("Server connection error: could not remove member from event, please try again later.");
          }
    });
  }
  });

  jQuery(".removeGuest").click(function(event) {
    event.preventDefault();
    var postid = jQuery("#add-members").attr('postid');
    var guest_player = this.getAttribute("guest");
    var el =jQuery(this);
    jQuery.ajax({
      type: "POST",
      url: Admin.ajaxurl,
      data: "action=removeguest&id="+postid+"&guest_player="+guest_player+"&removeguestNonce="+Admin.removeguestNonce,
      success: function(data){
        if (data.success){
          el.closest("tr").remove();

        } else{
          alert(data.data.message);
        }},
        error: function(){
          alert("Server connection error: could not remove member from event, please try again later.");
        }
    });
  });

});
