$(function() {

    var resize = function() {
        var h = $(window).height() - $(".tob-bar-sr3yrzht3j").outerHeight();
        $(".layout-s898twt16c").height(h);
    }
    
    resize();
    setInterval(resize, 1000);

});