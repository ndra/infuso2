mod.init(".g9cJIui7ST", function() {

    var $container = $(this);
    
    $container.find(".quick-intervals .interval").click(function() {
        var from = $(this).attr("data:from");
        $container.find("input:hidden").eq(0).val(from);
        var to = $(this).attr("data:to");
        $container.find("input:hidden").eq(1).val(to);
    });
    
});