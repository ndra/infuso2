jQuery.fn.window = function(params) {

    var defaults = {
        width: 320,
        height: 240
    };
    
    params = $.extend({},defaults,params);

    var wnd = $("<div>").css({
        position: "fixed",
        width: params.width,
        height: params.height,
        background: "white",
        border: "1px solid gray",
        zIndex:100
    });
    
    // Ставит окно в центр экрана
    var centerWindow = function() {
        var left = ($(window).width() - wnd.outerWidth()) / 2;
        var top = ($(window).height() - wnd.outerHeight()) / 2;
        wnd.css({
            left: left,
            top: top
        });
    }
    
    wnd.appendTo("body");
    centerWindow();
    
    mod.call(params.call,function(html) {
        wnd.html(html);
    })

}