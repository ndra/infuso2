mod.init(".gOuxIB8D7X", function() {
    
    var $container = $(this);
    $container.submit(function(event) {
        event.preventDefault();
        mod.call({
            cmd: "infuso/heapit/controller/bargain/updateCallTime",
            bargainId: $container.attr("data:bargain"),
            data: $container.mod("formData")
        }, function(ret) {
            if(ret) {
                $container.window("close");
                mod.fire("comments/update-list");
            }
        })
    });
    
});