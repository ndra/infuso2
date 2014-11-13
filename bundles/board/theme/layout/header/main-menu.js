mod.init(".x55qv4lhb8m", function() {
    
    var $container = $(this);
    
    var ajaxPath = [
        "/board/",
    ];
    
    $container.find(".task-list").each(function() {
        ajaxPath.push($(this).attr("href"));
    })
    
    $container.find(".task-list").click(function(event) {
        var href = window.location.pathname;
        for(var i in ajaxPath) {
            if(href == ajaxPath[i]) {
                event.preventDefault();
                window.history.replaceState(null, null, $(this).attr("href"));
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
    
    mod.on("board/groupsChanged", function(data) {
        $container.find(".task-list").each(function() {
            var id = $(this).attr("data:status");
            $(this).find(".count").html(data.groups[id] * 1 || "");
        })
    });
    
})