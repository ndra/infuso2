$(function() {

    $(".task-list-rpu80rt4m0").mod("init", function() {
    
        var container = $(this);

        // Загружает список задач
        var load = function() {
            
            var ajaxContainer = container.find(".ajax-container");
        
            var loader =  container.find(".loader");
            loader.show();
            
            var callData = {
                cmd: "Infuso/Board/Controller/Task/getTasks",
                status: container.attr("data:status")
            };
            
            container.find(".c-toolbar").triggerHandler({
                type: "task/beforeLoad",
                callData: callData
            });
        
            mod.call(callData, function(data) {                
                loader.hide();
                ajaxContainer.html(data.html);
                container.find(".c-toolbar").triggerHandler({
                    type:"task/load",
                    ajaxData: data
                });
            });
        
        }
        
        // Запускаем загрузку с 
        setTimeout(load,0);
        
        // При нажатии на F5 перегружаем список задач            
        $(document).keydown(function(event) {
            if(event.which === 116 && !event.ctrlKey) {
                load();
                event.preventDefault();
            }
        });
        
        container.on("task/filter-changed", function(e) {
            e.preventDefault();
            load();
        });
        
    });

}); 