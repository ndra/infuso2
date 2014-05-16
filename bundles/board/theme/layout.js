$(function() {

    var resize = function() {
        var h = $(window).height() - $(".tob-bar-sr3yrzht3j").outerHeight();
        $(".layout-slpod3n5sa").height(h);
        $(".task-container-slpod3n5sa")
            .css({
                top:$(".tob-bar-sr3yrzht3j").outerHeight()
            })
            .height(h);
    }
    
    resize();
    setInterval(resize, 1000);
    $(window).resize(resize);
    
    // Функция для закрытия окна    
    var closeTask = function() {  
        if($(".task-container-slpod3n5sa:visible").length) {
            $(".task-container-slpod3n5sa").hide();
            window.history.back();
        }
    }
    
    // Клик на кнопку «Закрыть»
    $(".task-container-slpod3n5sa .close").click(closeTask);
    
    // Esc
    $(document).keydown(function(e) {
        if(e.which == 27) {
            closeTask();
        }
    });
    
    // Открытие задачи
    mod.on("openTask", function(id) {
        mod.call({
            cmd:"infuso/board/controller/task/getTask",
            taskId: id
        }, function(data) {
            window.history.pushState(null, null, data.taskURL);
            $(".task-container-slpod3n5sa").show();
            $(".task-container-slpod3n5sa").find(".ajax").html(data.html);            
        });    
    
    });

});