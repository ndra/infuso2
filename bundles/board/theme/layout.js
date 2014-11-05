$(function() {
    
    var $container = $(".layout-slpod3n5sa");
    var $style = null;

    $container.layout();
    
    // Разворачивает левую панель
    var expandLeft = function() {
        
        $container.children(".left")
            .animate({
                width: 500
            }, {
                duration: 300,
                progress: function() {
                    $container.layout("update");
                }, complete: function() {
                    $container.layout("update");
                }
            });        
    }
    
    // Сворачивает левую панель
    var collapseLeft = function() {
        $container.children(".left")
            .animate({
                width: 1
            }, {
                duration: 300,
                progress: function() {
                    $container.layout("update");
                }, complete: function() {
                    $container.layout("update");
                }
            }); 
        deselectTask();
    }
    
    var selectTask = function(taskId) {
        if(!$style) {
            $style = $("<style>").appendTo("head");
        }
        $style.html(".task-" + taskId + " { outline:3px solid blue; }");
    }
    
    var deselectTask = function() {
        if($style) {
            $style.html("");
        }
    }
    
    // Открываем задачу
    $container.on("board/openTask", function(event) {
        
        //$container.children(".left").html("");
        expandLeft();
    
        mod.call({
            cmd: "infuso/board/controller/task/getTask",
            taskId: event.taskId
        }, function(data) {
            $container.children(".left").html(data.html);
        });
        
        selectTask(event.taskId);

    });
    
    // Открываем задачу
    $container.on("board/newTask", function(event) {
        expandLeft();
        if(event.cloneTask) {
            mod.call({
                cmd:"infuso/board/controller/task/newTask",
                cloneTask: event.cloneTask
            }, function(data) {
                $container.trigger({
                    type: "board/openTask",
                    taskId: data.taskId
                })
            });
        } else {
            mod.call({
                cmd: "infuso/board/controller/task/newTaskWindow",
                groupId: event.groupId
            }, function(data) {
                $container.children(".left").html(data.html);
            });
            deselectTask();
        }
    });
    
    var close = function() {
        collapseLeft();
    }
    
    $(document).keydown(function(event) {
        if(event.which == 27) {
            close();
        }
    })
    
});