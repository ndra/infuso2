mod.init(".F32KKaOgV7", function() {
    
    var $container = $(this);
    
    $container.find("span").click(function() {
        var page = $(this).attr("data:page")
        mod.msg(page);
    });
    
    
})