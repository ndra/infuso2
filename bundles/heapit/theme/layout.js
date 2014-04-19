$(function() {

    var resize = function() {
        var h = $(window).height() - $(".main-menu").outerHeight();
        $(".layout-slpod3n5sa").height(h);
    }
    
    resize();
    setInterval(resize, 1000);

});