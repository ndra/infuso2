mod.init(".LPtmRzde2d", function() {
    
    var $container = $(this);
    
    $container.click(function() {
        $.window({
            title: "Отложить",
            call: {
                cmd: "infuso/heapit/controller/bargain/callTimeContent",
                bargainId: $container.attr("data:bargain")
            }
        });
    });
    
})