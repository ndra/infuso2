mod.init(".F32KKaOgV7", function() {
    
    var $container = $(this);
    
    $container.find("span").click(function() {
        var page = $(this).attr("data:page")
        $(this).trigger({
            type: "reflex/setPage",
            page: page
        })
    });
    
    
})