mod.init(".MhpEuDh2NX", function() {
    
    var $container = $(this);
    $container.layout();
    

    var $tabs = $container.find(".center .tab");
    var $center = $container.find(".center");
    
    var selectTab = function(status) {
        
        var num = 0;

        $center.find(".roller .tab").each(function(n) {
            if($(this).attr("data:id") == status) {
                num = n;
            }
        });

        $center.find(".roller").animate({
            left: - (num * 100) + "%"    
        },"fast");
    };

    mod.on("board/show-status", function(data) {
        selectTab(data.status);
    });

    
});