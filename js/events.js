

jQuery().ready(function() {

  $(".email_addresses").focus(function()
  {
    $(this).select();
  }
  );

  $(".panel.event:first>.panel-collapse").addClass("in");





$(".event").each(function(){
var name = $(this).attr("name");
var id = $(this).attr("id-event");
var selector = ("button.register."+name);
var selector_unregister = ("button.unregister."+name);
var icon_notregistered='<i class="fa notregistered fa-square-o fa-lg text-right '+id+'">';
var icon_registered='<i class="fa fa-check-square-o fa-lg registered text-right  '+id+'"></i>';

var badge =
'<span class="badge '+name+'">%COUNT%</span>';

var form_details=$("#form-details-"+id).val();
if (form_details==="") {
   $("#form-details-"+id).val("None");
}


var table_row= "<tr user='"+userid+"'><td>"+username+ "</td><td>"+useremail+"</td></tr>";

$("#edit-details-"+id).click(function(){
  $("#form-details-"+id).prop('disabled', false);
  if ($("#form-details-"+id).val()==="None"){
    $("#form-details-"+id).val("");
  }
  $("#submit-details-"+id).toggle();
  $("#cancel-details-"+id).toggle();
  $("#edit-details-"+id).toggle();
  });

$("#cancel-details-"+id).click(function(){
  $("#form-details-"+id).prop('disabled', true);
  $("#submit-details-"+id).toggle();
  $("#cancel-details-"+id).toggle();
  $("#edit-details-"+id).toggle();
});

$("#submit-details-"+id).click(function(){
  var name = $(this).attr("name");
  var details = $('#form-details-'+id).val();
  $.ajax({
         type: "POST",
         url: Events.ajaxurl,
         data: "action=addmember&id="+id+"&member="+userid+"&details="+details+"&addmemberNonce=" + Events.addmemberNonce,
         success: function(data){
          if (data.success) {
          $("#form-details-"+id).prop('disabled', true);
          $("#submit-details-"+id).toggle();
          $("#cancel-details-"+id).toggle();
          $("#edit-details-"+id).toggle();
          if ($("#form-details-"+id).val()===""){
            $("#form-details-"+id).val("None");
          }
          }else{
            $('#danger-message').html('Oops! Something went wrong updating details for event, please try again later.');
            $('#alert-danger').fadeIn('slow');
          }
        },
        error: function(){
          $('#danger-message').html("Server connection error: could not update details for event, please try again later.");
          $('#alert-danger').fadeIn('slow');
        }
       });
     });

$("input").tooltip({'trigger':'focus', 'title': 'Optional details for registration'});
$(".btn-copy-email").tooltip({'trigger':'hover', 'title': 'Copy email addresses to clipboard'});

$(selector).click(function() {
var name = $(this).attr("name");
var details = $('#registration-input-'+name).val();
$.ajax({
       type: "POST",
       url: Events.ajaxurl,
       data: "action=addmember&id="+id+"&member="+userid+"&details="+details+"&addmemberNonce=" +Events.addmemberNonce,
       success: function(data){
        if (data.success){
              $("i.notregistered."+id).replaceWith(icon_registered);
              //$(alert).insertAfter("p.registered."+name);
              $("button.close").click(function()
              {
                $("#dismiss-"+name).hide();
              });
              $(".input-group."+name).toggle();
              $("button.unregister."+name).toggle();

              var newcount=parseInt($(".badge."+name).text())+1;
              var newbadge= badge.replace("%COUNT%", newcount);
              $(".badge."+name).replaceWith(newbadge);
              $(table_row).appendTo("#people_"+name+" "+"table");
              $("#form-details-"+id).prop('disabled', false);
              $("#form-details-"+id).val(details);
              $("#form-details-"+id).prop('disabled', true);
              $(".reg-details."+id).toggle();
            }else{
              $('#danger-message').html('Oops! Something went wrong registering for event, please try again later.');
              $('#alert-danger').fadeIn('slow');
              //alert(data.data.message);
          }
          },
          error: function(){
            $('#danger-message').html("Server connection error: could not register for event, please try again later.");
            $('#alert-danger').fadeIn('slow');
          }
     });
});

$(selector_unregister).click(function() {
jQuery.ajax({
       type: "POST",
       url: Events.ajaxurl,
       data: "action=removemember&id="+id+"&member="+userid+"&removememberNonce=" +Events.removememberNonce,
       success: function(data){
         if (data.success){
              $("i.registered."+id).replaceWith(icon_notregistered);
              $("button.close").click(function()
              {
                $("#dismiss-"+name).hide();
              });
              $("button.unregister."+name).toggle();
              $(".input-group."+name).toggle();
              $(".reg-details."+id).toggle();
              var newcount=parseInt($(".badge."+name).text())-1;
              var newbadge= badge.replace("%COUNT%", newcount);
              $(".badge."+name).replaceWith(newbadge);
              $("#people_"+name+" "+"table tr").each(function(){
                  var row_user = this.getAttribute("user");
                  if (row_user===userid){
                    this.remove();
                  }
              }
              );

          }else{
            $('#danger-message').html('Oops! Something went wrong unregistering for event, please try again later.');
            $('#alert-danger').fadeIn('slow');
            //alert(data.data.message);
          }
       },
       error: function(){
         $('#danger-message').html("Server connection error: could not remove member from event, please try again later.");
         $('#alert-danger').fadeIn('slow');
         //alert("Server connection error: could not remove member from event, please try again later.");
       }
     });
});

});
});
