mod.init(".doa3wGMQ2r", function() {
    
    var $container = $(this);
    var $begin = $container.find(".begin");
    var $log = $container.find(".log");
    
    var mode = "import";
    
    $begin.click(function() {
        mode = "import";
        step();
    });
    
    var step = function() {
    
        if(mode == "import") {
            mod.call({
                cmd: "infuso/eshop1c/controller/import/importxml"    
            }, function(data) {
                if(data.done) {
                    mode = "offers";    
                }
                $log.text(data.log);
                step();
            });
        }
        
        if(mode == "offers") {
            mod.call({
                cmd: "infuso/eshop1c/controller/import/offersxml"    
            }, function(data) {
                $log.text(data.log);
                if(data.done) {
                    $log.text("Выполнено");
                    return;
                }
                step();
            });
        }
        
    };
    
    
    
});