mod.init(".task-list-rpu80rt4m0", function() {
    
    var $container = $(this);
    var $ajaxContainer = $container.find(".ajax-container");
    var $loader =  $container.find(".loader");
    
    var $pager = $container.find(".fr8dqef87w");
    
    var group = $container.attr("data:status");
    var $query = $container.find("input[name='query']");
    var page = 1;

    // Загружает список задач
    var load = function() {
        
        var callData = {
            cmd: "Infuso/Board/Controller/Task/getTasks",
            group: group,
            query: $query.val(),
            page: page
        };
        
        $container.find(".c-toolbar").triggerHandler({
            type: "task/beforeLoad",
            callData: callData
        });
        
        var handler = function(data) { 
            $loader.hide();
            $container.pager("total", data.pages);
            $ajaxContainer.html(data.html);
            $container.find(".c-toolbar").triggerHandler({
                type:"task/load",
                ajaxData: data
            });
        };
    
        mod.call(callData, handler);

        $loader.show();
    
    }
    
    $container.on("board/load", load);
    
    $pager.on("change", function(e) { page = $pager.find("input").val(); load();  });
    
    
    // Настраиваем поиск
    $query.on("input", function() {
        load();
    })

    $container.on("board/setGroup", function(event) {
        group = event.group;
        load();
    });
    
    // При нажатии на F5 перегружаем список задач            
    $(document).keydown(function(event) {
        if($container.is(":visible")) {
            if(event.which === 116 && !event.ctrlKey) {
                load();
                event.preventDefault();
            }
        }
    });
    
    // При изменении задачи, перезагружаем
    mod.on("board/taskChanged", function(data) {
        if($container.is(":visible")) {
            setTimeout(load, 10);
        }
    });

    // При установке фокуса на окно, перезагружаем
    $(window).focus(function() {
        if($container.is(":visible")) {
            load();
        }
    });
    
});