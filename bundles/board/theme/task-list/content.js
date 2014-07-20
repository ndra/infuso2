mod.init(".MhpEuDh2NX", function() {
    
    var $container = $(this);
    var $tabs = $container.find("> .status-list-wrapper > .status-list span");
    var $tabsData = $container.find("> table > tbody > tr > td");
    $tabs.each(function(n) {
        $(this).click(function() {
            var $data = $tabsData.eq(n);
            var offset = $data.position().left + $container.parents(".center").get(0).scrollLeft;
            $container.parents(".center").animate({
                scrollLeft: offset
            }, 500);
        })
    })
    
});