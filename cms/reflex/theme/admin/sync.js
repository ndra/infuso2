mod(".x0f1k9gbr5c").init(function() {
    
    var $container = $(this);
    
    // Выделить все 
    $container.find(".select-all").click(function() {
        $container.find(":checkbox").prop("checked", true);
    });

    // Снять выделение
    $container.find(".deselect").click(function() {
        $container.find(":checkbox").prop("checked", false);
    });

    // Начать
    $container.find(".go").click(function() {
        $container.find(".class").removeClass("done");
        nextClass();
    });

    var fromId = null;
    var className = null;
    
    // Выводит лог
    var log = function(data) {
       $(".x0f1k9gbr5c .class-"+data["class"]+" .log").html(data.message);
    }
    
    var handleStep = function(data) {
    
        if(!data) {
            stepFailed();
            return;
        }        
        
        if(data.log) {
            log(data.log)
        }
        
        if(data.action == "nextClass") {
            $container.find(".class-"+data["log"]["class"]).addClass("done");
            nextClass();
            return;
        }
        
        if(data.action == "nextId") {
            fromId = data.nextId;
            step();
            return;
        }
    
    }
    
    var step = function() {
        mod.call({
            cmd:"infuso/cms/reflex/controller/sync/syncStep",
            className: className,
            fromId: fromId
        }, handleStep, {unique: "jn00F53tRf"});
    }
    
    var done = function() {
        mod.msg("done");
    }
    
    // Делает запрос для следующего класса
    // Если следующего класса нет - выполнено
    var nextClass = function() {
        
        className = null;
        $container.find(".class").not(".done").each(function() {
            if(className) {
                return;
            }
            var $checkbox = $(this).find(":checkbox:checked");
            if($checkbox.length) {
                className = $(this).attr("data:class");
            }
        });
        
        if(!className) {
            done();
        } else {
            fromId = 0;
            step();
        }
    }

});