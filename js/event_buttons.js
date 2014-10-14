jQuery().ready(function() {
$(".panel").each(function(){
var name = $(this).attr("name");
var id = $(this).attr("id");
var selector = ("button.register."+name);
var selector_unregister = ("button.unregister."+name);
var message_register='<p class="registration '+id+'"><i class="fa registration fa-check-square-o fa-2x"></i>  Registered</p>';
var message_unregister='<p class="registration '+id+'"><i class="fa fa-square-o fa-2x registration"></i>  Not registered</p>';
var alert= '<div id="dismiss-'+name+'" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss-'+ name +'" >x</button><p> %s!</p></div>';
var alert2 = '<div id="dismiss" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss" >x</button><p> Sometext!</p></div>';

$("input").tooltip({'trigger':'focus', 'title': 'Optional details for registration'});

$(selector).click(function() {
$.ajax({
       type: "POST",
       url: ajaxurl,
       data: "action=newmember&id="+id+"&member="+userid+"&remove=false",
       success: function(data){
              $("p.registration."+id).replaceWith(message_register);
              $(alert).insertAfter("p.registered."+name);
              $("button.close").click(function()
              {
                $("#dismiss-"+name).hide();
              });
              $("button.register."+name).hide();
              $("button.unregister."+name).css('display','inline');
       }
     });
});

$(selector_unregister).click(function() {
jQuery.ajax({
       type: "POST",
       url: ajaxurl,
       data: "action=newmember&id="+id+"&member="+userid+"&remove=true",
       success: function(data){
              $("p.registration."+id).replaceWith(message_unregister);
              $(alert).insertAfter("p.registered."+name);
              $("button.close").click(function()
              {
                $("#dismiss-"+name).hide();
              });
              $("button.unregister."+name).hide();
              $("button.register."+name).css('display','inline');
       }
     });
});

});
});
