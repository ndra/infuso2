$(function() {

    $(".getcbtu0lh").mod("init", function() {
    
        var container = $(this);

        $(this).find(".list-item").not(".folder").click(function() {
            // Клик на выбиралку пропускаем
            if($(event.target).is(".select-handle")) {
                return;
            }
            
            $(this).trigger({
                type: "reflex/storage/file",
                filename: $(this).attr("data:filename"),
                preview150: $(this).attr("data:preview150")
            });
            
            mod.msg(12);
            
        });
        
        $(this).list({
            selectHandle: ".select-handle",
            easyMultiselect: true
        });
        
        $(this).on("list/select", function(event) {
            var selected = container.find(".list-item.selected").not(".folder").eq(0);
            event.filename = selected.attr("data:filename");
            event.preview150 = selected.attr("data:preview150");
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
    
    });

});