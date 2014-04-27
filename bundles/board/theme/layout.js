$(function() {

    var resize = function() {
        var h = $(window).height() - $(".tob-bar-sr3yrzht3j").outerHeight();
        $(".layout-slpod3n5sa").height(h);
    }
    
    resize();
    setInterval(resize, 1000);
    
    mod.on("openTask", function(id) {
        $.window({
            width:800,
            height: 500,
            call: {
                cmd:"infuso/board/controller/task/getTask",
                taskId: id
            }
        })
    });

});