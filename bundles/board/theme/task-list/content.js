mod.init(".MhpEuDh2NX", function() {
    
    var $container = $(this);
    $container.layout();
    

    var $tabs = $container.find(".center .tab");
    var $center = $container.find(".center");
    
    var selectTab = function(n) {
        $center.find(".roller").animate({
            left: - (n * 100) + "%"    
        },"fast");
    };

    mod.on("board/show-status", function(data) {
        selectTab(data.status);
    });

    
});