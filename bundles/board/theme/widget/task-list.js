mod.init(".task-list-rpu80rt4m0", function() {
    
    var $container = $(this);
    
    var groupId = 0;

    // Загружает список задач
    var load = function() {
        
        var $ajaxContainer = $container.find(".ajax-container");
        var $loader =  $container.find(".loader");
        
        $loader.show();
        
        var callData = {
            cmd: "Infuso/Board/Controller/Task/getTasks",
            status: $container.attr("data:status"),
            groupId: groupId
        };
        
        $container.find(".c-toolbar").triggerHandler({
            type: "task/beforeLoad",
            callData: callData
        });
    
        mod.call(callData, function(data) {                
            $loader.hide();
            $ajaxContainer.html(data.html);
            $container.find(".c-toolbar").triggerHandler({
                type:"task/load",
                ajaxData: data
            });
            resize();
        });
    
    }
    
    // Запускаем загрузку с задержкой, чтобы сработали обработчики событий
    setTimeout(load,0);
    
    $container.on("board/openGroup", function(event) {
        groupId = event.groupId;
        load();
    });
    
    // При нажатии на F5 перегружаем список задач            
    $(document).keydown(function(event) {
        if(event.which === 116 && !event.ctrlKey) {
            load();
            event.preventDefault();
        }
    });
    
    $container.on("task/filter-changed", function(e) {
        e.preventDefault();
        load();
    });
    
    mod.on("board/taskChanged", function(data) {
        load();
    });
    
    $(window).focus(load);
    
    var resize = function() {
        var height = $(window).height() - 200;
        var itemHeight = 140;
        var itemWidth = 130;
        // Число стикеров
        // +1 т.к. у нас есть кнопка добавления задачи
        var n = $container.find(".ajax-container .task").length + 1;
        var nv = Math.floor(height / itemHeight);
        var nh = Math.ceil(n / nv);
        var maxWidth = $(window).width() * 0.9; 
        $container.width(Math.min(maxWidth,nh * itemWidth));
    }
    
    setInterval(resize, 1000);
    
});