mod.init(".x55qv4lhb8m", function() {
    
    var $container = $(this);
    
    var ajaxPath = [
        "/board/",
        "/board/backlog/",
        "/board/request/",
        "/board/inprogress/",
    ];
    
    $container.find(".task-list").click(function(event) {
        var href = window.location.pathname;
        for(var i in ajaxPath) {
            if(href == ajaxPath[i]) {
                event.preventDefault();
                window.history.replaceState(null, "Ололо!", $(this).attr("href"));
            }
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