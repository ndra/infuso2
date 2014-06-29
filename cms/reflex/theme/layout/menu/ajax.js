mod.init(".ddw7fs4b37", function() {
    $container = $(this);
    
    $container.find(".left .tab").click(function() {
        $(this).trigger({
            type: "reflex/tab",
            tab: $(this).attr("data:tab")
        });
    })
    
});