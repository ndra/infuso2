mod.init(".LzMqPQSsHk", function() {
    
    var $container = $(this);
    
    // Удаление элекмента из корзины
    $container.find(".delete").click(function() {
        var id = $(this).attr("data:item");
        mod.call({
            cmd:" infuso/eshop/controller/cart/delete",
            itemId: id
        }, function() {
            window.location.reload();
        });
    });
    
    // Очистка корзины
    $container.find(".actions .clear").click(function() {
        mod.call({
            cmd:" infuso/eshop/controller/cart/clear"
        }, function() {
            window.location.reload();
        });
    })
    
})