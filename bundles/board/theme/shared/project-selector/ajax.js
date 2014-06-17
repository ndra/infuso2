mod.init(".TfFKQlQcVt", function() {
    
    $container = $(this);
    $container.find(".item").click(function() {
        var id = $(this).attr("data:id");
        $(this).trigger({
            type: "board/project-selector/select",
            projectId: id
        });
    });
    
})