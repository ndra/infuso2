$(function() {
    $(".vlk5bx6x1q").mod("init",function() {
        var container = $(this).find(".items");
        mod.call({
            cmd: "infuso/heapit/controller/comments/list"
        }, function(html) {
            container.html(html);
        })
    });
});