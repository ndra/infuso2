$.fn.pager = function(p1,p2) {

    if(p1 === undefined) {
        return $.merge($(this).find(".fr8dqef87w"),$(this).filter(".fr8dqef87w"));
    }

    if(p1 === "total") {
        $(this).pager().data("total", p2);
        $(this).pager("render");
    }

    if(p1 === "select") {
        $(this).pager().find("input:first").val(p2);
        $(this).pager("render");
        $(this).pager().trigger("change");
    }

    if(p1 === "render") {

        var container = $(this).pager();
        var items = container.find(".pages").html("");
        var active = $(this).pager().find("input:first").val() * 1;
        var total = container.data("total");

        var range = 5;
        var from = Math.max(active - range, 1);
        var to = Math.min(active + range, total * 1);

        for(var i = from; i <= to; i++) {
            var button = $("<span class='page' >")
                .html(i)
                .appendTo(items)
                .data("page", i)
                .click(function() {
                    var page = $(this).data("page");
                    container.pager("select",page);
                });
            if(i == active) {
                button.addClass("active");
            }
        }
    }

};