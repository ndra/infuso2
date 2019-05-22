mod.init(".FQvC1t9aEV", function(event) {
    
    var $container = $(this);
    
    $container.find(".preset").click(function() {
        var $preset = $(this);
        mod.fire("battery-calculator/update", {
            cellId: $preset.attr("data:cell"),
            serial: $preset.attr("data:serial"),
            parallel: $preset.attr("data:parallel"),
        });
    });
    
});