mod.init(".EIvwPQRUtU", function() {
    
    var $container = $(this);
    
    $container.find(".apply-filter").click(function() {
        var data = mod($container).formData();
        console.log(data);
    });
    
});