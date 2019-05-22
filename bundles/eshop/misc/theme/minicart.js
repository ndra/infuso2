mod.init(".ToHNLAy098", function() {

    var $container = $(this);
    
    mod.on("eshop/cart-changed", function(data) {
        $container.find(".ajax-container").html(data.minicart);
    });

});