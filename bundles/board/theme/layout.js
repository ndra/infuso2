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
        
        if(!$style) {
            $style = $("<style>").appendTo("head");
        }
        
        $style.html(".task-" + event.taskId + " .sticker { outline:3px solid blue; }");

    });
    
    // Открываем задачу
    $container.on("board/newTask", function(event) {
        
        expandLeft();
        mod.call({
            cmd: "infuso/board/controller/task/newTaskWindow"
        }, function(data) {
            $container.children(".left").html(data.html);
        });
        
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