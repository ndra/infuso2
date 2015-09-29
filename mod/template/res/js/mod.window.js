jQuery.fn.window = function(params) {

    if(params == "close") {
        $(this).window().remove();
        return this;
    }

    if(params === undefined) {
        return $(this).parents(".5jfNUBs7a9zwHl:first").andSelf(".5jfNUBs7a9zwHl:first");
    }
    
    if(params == "contentElement") {
        return $(this).window().children(".content");
    }

};

jQuery.window = function(params) {

    var defaults = {
        width: 320,
        height: 240,
        zIndex: 100,
        events: {}
    };

    params = $.extend({},defaults,params);
    
    // Закрывает окно
    var close = function() {
        $wnd.remove();
    }

    // Ставит окно в центр экрана
    var centerWindow = function() {
        var left = ($(window).width() - $wnd.outerWidth()) / 2;
        var top = ($(window).height() - $wnd.outerHeight()) / 2;
        $wnd.css({
            left: left,
            top: top
        });
    }

	// Контейнер окна
    var $wnd = $("<div>").css({
        position: "fixed",
        width: params.width,
        height: params.height,
        background: "white",
        boxShadow: "0 0 10px black",
        zIndex:params.zIndex
    }).addClass("5jfNUBs7a9zwHl");

	// Хэдер
    var $header = $("<table>").css({
        position: "relative",
        background: "#ededed",
        width: "100%",
        "table-layout": "fixed",
    }).appendTo($wnd);
    
    var $tr = $("<tr>").appendTo($header);

    $("<td>").css({
        right: 4,
        top: 4,
        padding: 4,
		width: "100%"
    }).appendTo($tr)
        .html(params.title ? params.title : "");

    $("<td>").css({
        right: 4,
        top: 4,
        width: 12,
        padding: 4,
        cursor: "pointer"
    }).appendTo($tr)
        .html("&#10006;")
        .click(close);
        
    $wnd.appendTo("body");
    
    var $content = $("<div>").css({
        height: params.height - $header.outerHeight(),
        overflow: "auto"
    }).addClass("content")
	.appendTo($wnd);
    
    centerWindow();

	// Делаем запрос к серверу
	if(params.call) {
	    mod.call(params.call,function(html) {
	        $content.html(html);
	    });
    }
    
    return $wnd;

}
