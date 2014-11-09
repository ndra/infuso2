mod.init(".task-list-rpu80rt4m0", function() {
    
    var $container = $(this);
    var $ajaxContainer = $container.find(".ajax-container");
    var $loader =  $container.find(".loader");
    
    var status = $container.attr("data:status");
    
    var path = 0;

    // Загружает список задач
    var load = function() {
        
        var callData = {
            cmd: "Infuso/Board/Controller/Task/getTasks",
            status: $container.attr("data:status"),
            path: path
        };
        
        $container.find(".c-toolbar").triggerHandler({
            type: "task/beforeLoad",
            callData: callData
        });
        
        var handler = function(data) {                
            $loader.hide();
            $ajaxContainer.html(data.html);
            $container.find(".c-toolbar").triggerHandler({
                type:"task/load",
                ajaxData: data
            });
        };
    
        mod.call(callData, handler);

        $loader.show();
    
    }


    // Запускаем загрузку с задержкой, чтобы сработали обработчики событий
    setTimeout(load, 0);
    
    $container.on("board/setPath", function(event) {
        path = event.path;
        load();
    });
    
    // При нажатии на F5 перегружаем список задач            
    $(document).keydown(function(event) {
        if(event.which === 116 && !event.ctrlKey) {
            load();
            event.preventDefault();
        }
    });
    
    // При изменении фильтра, перезагружаем
    $container.on("task/filter-changed", function(e) {
        load();
    });
    
    // При изменении задачи, перезагружаем
    mod.on("board/taskChanged", function(data) {
        setTimeout(load, 10);
    });
    
    // При установке фокуса на окно, перезагружаем
    $(window).focus(load);
    
});