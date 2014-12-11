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
            alert("Could not remove member from event, please try again later.");
          }
        });
        });
        });

    // Set current date to start date of event and set mindate for enddate and maxdate for deadline
    jQuery( '#start-date' ).datepicker({
        dateFormat: 'dd MM yy',
        minDate: 0,
        onClose: function( selectedDate ){
            $( '#end-date' ).datepicker( 'option', 'minDate', selectedDate);
            $( '#end-date' ).datepicker('setDate', selectedDate);
            $( '#deadline' ).datepicker( 'option', 'maxDate', selectedDate);
        }
    });
    jQuery( '#end-date' ).datepicker({
        dateFormat: 'dd MM yy',
        onClose: function( selectedDate ){
            $( '#start-date' ).datepicker(  'option', 'maxDate', selectedDate);
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
      members.forEach(function(entry){
        members_string+=entry+",";
      });

      members_string = members_string.substring(0, members_string.length - 1);
      // Ajax request to add members
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
                         alert("Could not remove member from event, please try again later.");
                       }
                     });
              });
            }else{
              alert(data.data.message);
            }
           },
           error: function(){
             alert("Could not add member to event, please try again later.");
           }
           }
           );
    });



});
