$(function() {

    $(".getcbtu0lh").mod("init", function() {
    
        var container = $(this);

        /*$(this).mousedown(function() {
            $(this).toggleClass("selected");
        });
        
        $(this).dblclick(function() {
            var filename = $(this).attr("data:filename");
           // var preview = 
            $(this).window().trigger("selectFile", [filename]);
        }); */
        
        $(this).list();
        
        $(this).find(".folder").click(function() {
            var path = $(this).attr("data:id");
            container.trigger({
                type: "reflex/storage/cd",
                path: path
            });
        });
        
        $(this).find(".back-path").click(function() {
            var path = $(this).attr("data:path");
            container.trigger({
                type: "reflex/storage/cd",
                path: path
            });
        });
    
    });

});