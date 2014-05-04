$(function() {

    $(".getcbtu0lh").mod("init", function() {
    
        var container = $(this);

        /*$(this).dblclick(function() {
            var filename = $(this).attr("data:filename");
           // var preview = 
            $(this).window().trigger("selectFile", [filename]);
        }); */
        
        $(this).list({
            selectHandle: ".select-handle",
            easyMultiselect: true
        });
        
        // При клике на папку, меняем текущуюу папку
        // Если мы кликнули на выбиралку, папку не меняем
        $(this).find(".folder").click(function(event) { 
        
            // Клик на выбиралку пропускаем
            if($(event.target).is(".select-handle")) {
                return;
            }
             
            // Меняем папку  
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