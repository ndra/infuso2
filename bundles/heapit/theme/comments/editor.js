mod.init(".B5AhPI5rlz", function() {
    
    var $container = $(this);
    
    $container.submit(function(e) {        
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd: "infuso/heapit/controller/comments/save",
            commentId: $container.attr("data:id"),
            data:data
        }, function() {
            $container.trigger("save");
            $container.window("close");
        });
    });
    
});