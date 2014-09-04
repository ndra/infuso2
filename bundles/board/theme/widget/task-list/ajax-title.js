mod.init(".YkELjC2q38", function() {
    
    var $container = $(this);
    
    // Нажатие на задачу
    $container.find(".back").click(function(event) {
        $(this).trigger({
            type: "board/openGroup",
            groupId: 0
        });    
    });
    
    $container.find(".title").click(function() {
        $(this).trigger("board/toggleTaskList");
    });
    
});