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
    
    var header = $("<div>").css({
        position: "relative",
        height: 20,
        background: "#ededed"
    }).appendTo(wnd);
    
    var close = function() {
        wnd.remove();
    }
    
    $("<div>").css({
        position: "absolute",
        right: 4,
        top: 4
    }).appendTo(header)
        .html("Закрыть")
        .click(close);
    
    var content = $("<div>").css({
        height: params.height - header.outerHeight()
    }).appendTo(wnd);
    
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
        content.html(html);
    });

}