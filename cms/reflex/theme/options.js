mod.init(".EIvwPQRUtU", function() {
    
    var $container = $(this);
    
    $container.find(".apply-filter").click(function() {
        var data2 = mod($container).formData();
        var data = {};
        var found = false;
        for(var i in data2) {
            if(data2[i]) {
                data[i] = data2[i];
                found = true;
            }
        }
        
        if(!found) {
            data = null;
        }
        
        $container.trigger({
            type: "reflex/setFilterData",
            filters: data
        });
        
        $container.window("close");
        
    });
    
});