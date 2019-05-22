mod.init(".q07p5QGdib", function() {
    
    var $container = $(this);
    
    $container.find(".plus").click(function() {
        var val = Math.max(0, parseInt($container.find("input").val())) + 1 || 1;
        $container.find("input").val(val).trigger("change");
    })
    
    $container.find(".minus").click(function() {
        var val = Math.max(0, parseInt($container.find("input").val())) - 1 || 1;
        $container.find("input").val(val).trigger("change");
    })
    
    
});