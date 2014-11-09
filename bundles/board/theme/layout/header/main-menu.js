mod.init(".x55qv4lhb8m", function() {
    
    var $container = $(this);
    
    $container.find(".task-list").click(function(event) {
        if(this.href == window.location.href) {
            event.preventDefault();
        }
        mod.fire("board/show-status", {
            status: $(this).attr("data:status")
        });
    });
    
    $container.find(".new-task").click(function(event) {
        event.preventDefault();
        $(this).trigger({
            type: "board/newTask",
            groupId: $container.attr("data:group")
        });
    });
    
})