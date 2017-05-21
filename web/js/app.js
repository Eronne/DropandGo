//Apply opacity to the arrow
$(window).scroll( function(){
    var topWindow = $(window).scrollTop() * 1.5;
    var windowHeight = $(window).height();

    var position = topWindow / windowHeight;
    //invert the percentage
    position = 1 - position;
    $('.arrow-wrap').css('opacity', position);
    console.log('tr');

});




//Smooth scroll
var $root = $('html, body');
$('a').click(function() {
    var href = $.attr(this, 'href');
    $root.animate({
        scrollTop: $(href).offset().top
    }, 720, function () {
        window.location.hash = href;
    });
    return false;
});