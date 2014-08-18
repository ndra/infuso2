mod.init(".LzMqPQSsHk", function() {
    
    var $container = $(this);
    $container.find(".delete").click(function() {
        
        var id = $(this).attr("data:item");
        mod.call({
            cmd:" infuso/eshop/controller/cart/delete",
            itemId: id
        }, function() {
            window.location.reload();
        })
        
    });
    
    
})