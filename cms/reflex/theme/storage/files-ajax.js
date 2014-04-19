$(function() {

    $(".getcbtu0lh .item").mod("init", function() {

        $(this).mousedown(function() {
            $(this).toggleClass("selected");
        });
        
        $(this).dblclick(function() {
            mod.msg(1);
            var filename = $(this).attr("data:filename");
            $(this).window().trigger("selectFile", [filename]);
        });
    
    });

});