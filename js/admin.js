jQuery().ready(function() {



    jQuery(".user").each(function(){
      var id = jQuery(this).attr("id");
      var postid = jQuery("#add-members").attr('postid');

      jQuery("#unregister-"+id).click(function() {
        jQuery.ajax({
               type: "POST",
               url: ajaxurl,
               data: "action=removemember&id="+postid+"&member="+id,
               success: function(data){
                 alert("Removed: "+id+" succesfully!");
                 jQuery(".user-"+id).remove();

               }

             });


      });

    });


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


    jQuery(".chosen").chosen();



    jQuery("#add-members").click(function() {
    var postid = jQuery("#add-members").attr('postid');
    var members=jQuery("#select-members").val();
    var members_string ="";
    members.forEach(function(entry){
      members_string+=entry+",";
    });

    members_string = members_string.substring(0, members_string.length - 1);

    jQuery.ajax({
           type: "POST",
           url: ajaxurl,
           data: "action=addmembers&id="+postid+"&members="+members_string,
           success: function(data){
             members.forEach(function(entry){
               var table_row="<tr class='user user-"+entry+"' id='"+entry+"'><td style='border: 1px solid #999;padding: 0.5rem;'>"+entry+"</td><td style='border: 1px solid #999;padding: 0.5rem;'></td><td style='border: 1px solid #999;padding: 0.5rem;'></td>\
               <td style='border: 1px solid #999;padding: 0.5rem;' >"+"<button userid='"+entry+"' id='unregister-"+postid+"' style='height: 2.2em;width: 4em;' type='button'>X</button></td></tr>";
               jQuery(table_row).appendTo("#registered-members");
             });

            jQuery('#registered-members').on('click', 'button', function() {

              var userid=jQuery(this).attr("userid");
              jQuery.ajax({
                     type: "POST",
                     url: ajaxurl,
                     data: "action=removemember&id="+postid+"&member="+userid,
                     success: function(data){
                       jQuery(".user-"+userid).remove();
                     }
                   });
            });



           }
         });
    });
});
