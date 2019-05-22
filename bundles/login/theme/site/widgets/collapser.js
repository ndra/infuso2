mod(".jYPlW0sJt8").init(function() {
    
    var $container = $(this);
    var id = $container.attr("data:id");
    var keep = $container.attr("data:keep");
    var key = "ZKWTlwk0AB/" + id;
    var expand = function(now) {
        if(now) {
            $container.slideDown(0);
        } else {
            $container.slideDown("fast");
        }
        mod.fire("collapser/handle-expand/" + id);
        if(keep) {
            sessionStorage.setItem(key, 1);
        }
        $container.trigger("collapser/expand");
    };
    
    var collapse = function() {
        $container.slideUp("fast");
        mod.fire("collapser/handle-collapse/" + id);
        if(keep) {
            sessionStorage.setItem(key, 0);
        }
    }
    
    if(keep && sessionStorage.getItem(key) == 1) {
        expand(true);
        setTimeout(function() {
            expand(true);
        }, 0);
    }
    
    mod.on("collapser/expand/" + id, function() {
        expand();
    }, $container);
    
    mod.on("collapser/collapse/" + id, function() {
        collapse();
    }, $container);
        
}, {key: "UxN7B4fPCU"});