mod.init(".RKuqSeaR2V", function() {
    
    var $container = $(this);
    var $button = $container.find("input[type=button]");
    
    $button.click(function() {
        var itemId = $(this).attr("data:id");
        mod.call({
            cmd: "infuso/eshop/controller/cart/add",
            items: [{
                id: itemId,
            }]
        });
    });
    
});