jQuery().ready(function() {

$(".article>.al2fb_anchor").detach().appendTo(".post-meta");
$('[data-toggle="tooltip"]').tooltip();
$("#registration-input").tooltip({'trigger':'focus', 'title': 'Optional details for registration'});

var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
console.log("height: "+h);
console.log("width: "+w);
var newheight;
if ($("#wpadminbar").length>0){
  newheight=h-104;
  $(".navbar-collapse").css("max-height",newheight+"px");
}else{
  newheight=h-59;
  $(".navbar-collapse").css("max-height",newheight+"px");
}


if (h<300){

  $(".navbar-nav>li>a ").css("padding-top","10px");
  $(".navbar-nav>li>a ").css("padding-bottom","0px");
  $(".navbar-nav>li>a ").css("line-height","0px");
  $(".navbar-nav>li").css("height","40px");
  $(".navbar-nav>li:not(:has(*))").remove();
}

//.navbar-fixed-top .navbar-collapse
});
