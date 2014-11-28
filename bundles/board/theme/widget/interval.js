mod.init(".g9cJIui7ST", function() {

    var $container = $(this);
    
    $container.find(".quick-intervals .interval").click(function() {
        var from = $(this).attr("data:from");
        $container.find("input:visible").eq(0).trigger({
            type: "setDate",
            date: from
        });
        var to = $(this).attr("data:to");
        $container.find("input:visible").eq(1).trigger({
            type: "setDate",
            date: to
        });
    });
    
});