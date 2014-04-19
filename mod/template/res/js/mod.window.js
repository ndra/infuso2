jQuery.fn.window = function(params) {

    if(params == "close") {
        $(this).remove();
        return this;
    }

    if(params === undefined) {
        return $(this).parents(".5jfNUBs7a9zwHl:first");
    }

    var defaults = {
        width: 320,
        height: 240,
        events: {}
    };

    params = $.extend({},defaults,params);

    var wnd = $("<div>").css({
        position: "fixed",
        width: params.width,
        height: params.height,
        background: "white",
        boxShadow: "0 0 10px black",
        zIndex:100
    }).addClass("5jfNUBs7a9zwHl");

    // Навешиваем обработчики на окно
    for(var name in params.events) {
        wnd.on(name, params.events[name]);
    }

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
        top: 4,
        cursor: "pointer"
    }).appendTo(header)
        .html("Закрыть")
        .click(close);

    var content = $("<div>").css({
        height: params.height - header.outerHeight(),
        overflow: "auto"
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
