mod(".x0gLb3EEqo").init(function() {
    
    var $container = $(this);
    
    // ------------------------------------------------------
    
    $container.find("table.cell").tablesorter({ 
        sortList: [[0,0]] 
    }); 
    
    $container.on("collapser/expand", function() {
        $container.find("table.cell").formatTable();
    });
    
    // Клик на строку ---------------------------------------
    
    $container.find("table.cell tbody tr").click(function() {
        var id = $(this).attr("data:cell");
        mod.fire("battery-calculator/update", {
            cellId: id
        });
    });
    
    mod.on("battery-calculator/update", function(params) {
        if(params.cellId) {
            $container.find("tr").each(function() {
                var $tr = $(this);
                if($tr.attr("data:cell") != params.cellId) {
                    $tr.removeClass("active");
                } else {
                    $tr.addClass("active");
                }
            });
        }
        
    });
    
});