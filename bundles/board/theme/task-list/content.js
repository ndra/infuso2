mod.init(".MhpEuDh2NX", function() {
    
    var $container = $(this);
    $container.layout();
    
    var $pager = $container.find(".top .tab");
    var $tabs = $container.find(".center .tab");
    var $center = $container.find(".center");
    
    $pager.each(function(n) {
        $(this).click(function() {
            selectTab(n);
        });
    });
    
    var selectTab = function(n) {
        $center.find(".roller").animate({
            left: - (n * 100) + "%"    
        },"fast");
    };
    
    

    
});