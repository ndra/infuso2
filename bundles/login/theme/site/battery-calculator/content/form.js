mod.init(".verCFCn5J1", function() {
    
    var $container = $(this);
    
    var realUpdate = function() {
        $container.trigger("toolbarChanged");
        mod.fire("battery-calculator/update", {
            cellId: $container.find("input[name=cell]").val()
        }); 
        timeoutSet = false;
    };
    
    var timeoutSet = false;
    var update = function() {
        if(!timeoutSet) {
            setTimeout(realUpdate, 10);
            timeoutSet = true;
        }
    };
    
    $container.find("input,select")
        .on("change", update)
        .on("input", update);
        
    $container.on("beforeLoad", function(event) {
        var data = mod($container).formData();
        for(var i in data) {
            event.toolbar[i] = data[i];
        }
    });
    
    mod.on("battery-calculator/update", function(params) {
        
        if(params.cellId) {
            $container.find("input[name=cell]").val(params.cellId);
            update();
        }
        if(params.serial) {
            $container.find("input[name=serial]").val(params.serial);
            update();
        }
        if(params.parallel) {
            $container.find("input[name=parallel]").val(params.parallel);
            update();
        }
        
        var s = $container.find("input[name=serial]").val();
        var p = $container.find("input[name=parallel]").val();
        $container.find(".total").html(s * p);
    });
    
});