$(function() {

    $(".getcbtu0lh .item").mod("init", function() {

        $(this).mousedown(function() {
            $(this).toggleClass("selected");
        });
        
        $(this).dblclick(function() {
            var filename = $(this).attr("data:filename");
           // var preview = 
            $(this).window().trigger("selectFile", [filename]);
        });
    
    });

});