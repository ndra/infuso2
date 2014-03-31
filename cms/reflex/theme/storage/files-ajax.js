$(function() {

    $(".getcbtu0lh .item").mod().init(function() {

        $(this).mousedown(function() {
            $(this).toggleClass("selected");
        });
        
        $(this).dblclick(function() {
            var filename = $(this).attr("data:filename");
            $(this).mod().window().trigger("selectFile", [filename]);
        });
    
    });

});