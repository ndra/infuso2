mod.init(".task-list-rpu80rt4m0", function() {
    
    var $container = $(this);
    var $ajaxContainer = $container.find(".ajax-container");
    var $loader =  $container.find(".loader");
    
    var status = $container.attr("data:status");
    
    var firstLoad = true;
    
    var taskListVisible = true;
    
    var groupId = localStorage.getItem("board/groupId") || 0;
    if($container.attr("data:status") != "backlog") {
        groupId = 0;
    }

    // Загружает список задач
    var load = function() {
        
        var callData = {
            cmd: "Infuso/Board/Controller/Task/getTasks",
            status: $container.attr("data:status"),
            groupId: groupId
        };
        
        $container.find(".c-toolbar").triggerHandler({
            type: "task/beforeLoad",
            callData: callData
        });
        
        var storeData = function(data) {
            data = JSON.stringify(data);
            window.sessionStorage.setItem("bSUJTR4lWH" + status, data);
        }
        
        var restoreData = function() {
            var data = window.sessionStorage.getItem("bSUJTR4lWH" + status);
            data = JSON.parse(data);
            return data;
        }
        
        var handler = function(data) {                
            $loader.hide();
            $ajaxContainer.html(data.html);
            $container.find(".c-toolbar").triggerHandler({
                type:"task/load",
                ajaxData: data
            });
            storeData(data);
        };
    
        mod.call(callData, handler);
        
        if(firstLoad) {
            var storedData = restoreData();
            if(storedData) {
                handler(storedData);
            }
            firstLoad = false;
        }
        
        $loader.show();
    
    }

    /**
     * Разворачивает список задач
     **/
    var expandTaskList = function() {
        $ajaxContainer.slideDown();
        taskListVisible = true;
        window.localStorage.setItem("9a21aQbwcP" + status, 1);
    }
    
    /**
     * Сворачивает список задач
     **/
    var collapseTaskList = function() {
        $ajaxContainer.slideUp();
        taskListVisible = false;
        window.localStorage.setItem("9a21aQbwcP" + status, 0);
    }
    
    var restoreVisibility = function() {
        taskListVisible = window.localStorage.getItem("9a21aQbwcP" + status) * 1;
        $ajaxContainer.css("display", taskListVisible ? "block" : "none");
    }
    
    restoreVisibility();
    
    /**
     * Сворачивает/разворачивает список задач
     **/
    $container.on("board/toggleTaskList", function() {
        if(taskListVisible) {
            collapseTaskList();
        } else {
            expandTaskList();
        }
    });
    
    // Запускаем загрузку с задержкой, чтобы сработали обработчики событий
    setTimeout(load, 0);
    
    $container.on("board/openGroup", function(event) {
        groupId = event.groupId;
        localStorage.setItem("board/groupId", groupId);
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