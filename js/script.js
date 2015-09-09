// Copyright 2014-2015 Twitter, Inc.
// Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
  var msViewportStyle = document.createElement('style');
  msViewportStyle.appendChild(
    document.createTextNode(
      '@-ms-viewport{width:auto!important}'
    )
  );
  document.querySelector('head').appendChild(msViewportStyle);
}

jQuery().ready(function() {

jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();

var items=$(".form-control-wrap > img");

for (index = 0; index < items.length; ++index) {
  var item=items[index];
  var parent=item.parentElement;
  var target=jQuery(parent).find("label");
  target.append(item);
}

$(function () {
  $('[data-toggle="popover"]').popover();
});



$(".article>.al2fb_anchor").detach().appendTo(".post-meta");
$('[data-toggle="tooltip"]').tooltip();
$("#registration-input").tooltip({'trigger':'focus', 'title': 'Optional details for registration'});

resizeMenu();


$(window).on('resize orientationChange', function(event) {
    resizeMenu();
});


function resizeMenu(){
var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
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
}else{

}
}

});
