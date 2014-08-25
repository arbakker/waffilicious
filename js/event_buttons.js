jQuery().ready(function() {
$(".card").each(function(){
var name = $(this).attr("name");
var id = $(this).attr("id");
var selector = ("button.register."+name);
var selector_unregister = ("button.unregister."+name);

var message_register='<span><i class="fa registration fa-check-square-o fa-2x"></i>Registered</span>';
var message_unregister='<span><i class="fa fa-square-o fa-2x registration"></i>Not registered</span>';
var alert= '<div id="dismiss-'+name+'" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss-'+ name +'" >x</button><p> %s!</p></div>';
var alert2 = '<div id="dismiss" role="alert" aria-hidden="true" class="alert alert-dismissable" ><button class="close" data-dismiss-target="#dismiss" >x</button><p> Sometext!</p></div>';


$(selector).click(function() {
$.ajax({
       type: "POST",
       url: ajaxurl,
       data: "action=newmember&id="+id+"&member="+userid+"&remove=false",
       success: function(data){



              $("p.registered."+name+" span").replaceWith(message_register);

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

              $("p.registered."+name+" span").replaceWith(message_unregister);
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
