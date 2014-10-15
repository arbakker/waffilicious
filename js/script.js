jQuery().ready(function() {
$(".img-holder").imageScroll(
{
    coverRatio: 0.4,
    speed: 0.2,
    parallax: true
}
);
$("#registration-input").tooltip({'trigger':'focus', 'title': 'Optional details for registration'});
});
