mod.init(".task-list-rpu80rt4m0", function() {
    
    var $container = $(this);
    var $ajaxContainer = $container.find(".ajax-container");
    var $loader =  $container.find(".loader");    
    var groupId = 0;

    // Загружает список задач
    var load = function() {
        
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
            saveHTML(data.html);
        });
    
    }
    
    var saveHTML = function(html) {
        window.sessionStorage.setItem("bSUJTR4lWH" + $container.attr("data:status"), html);
    }
    
    var restoreHTML = function() {
        var html = window.sessionStorage.getItem("bSUJTR4lWH" + $container.attr("data:status"));
        $ajaxContainer.html(html);
    }
    
    restoreHTML();
    
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
        setTimeout(load, 10);
    });
    
    $(window).focus(load);
    
});