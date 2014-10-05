mod.init(".comments-nni5vez0qz", function() {
    
    var $container = $(this);
    
    $container.find(".edit").click(function() {
        $.window({
            width: 600,
            height: 400,
            call: {
                cmd: "infuso/heapit/controller/comments/get",
                id: $(this).attr("data:id")
            }
        }).on("save", function() {
            mod.fire("comments/update-list");
        });
    });
});