mod.init(".RKuqSeaR2V", function() {
    $container = $(this);
    $button = $container.find("input[type=button]");
    $button.click(function() {
        var itemId = $(this).attr("data:id");
        mod.call({
            cmd: "infuso/eshop/controller/cart/add",
            itemId: itemId
        })
    });
})