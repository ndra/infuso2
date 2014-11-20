mod.init(".g9cJIui7ST", function() {

    var $container = $(this);
    
    $container.find(".quick-intervals .interval").click(function() {
        var from = $(this).attr("data:from");
        $container.find("input[name='a']").trigger({
            type: "setDate",
            date: from
        });
        var to = $(this).attr("data:to");
        $container.find("input[name='b']").trigger({
            type: "setDate",
            date: to
        });
    });
    
});