mod.init(".ij0BvYHLIj", function() {
   
    var $container = $(this);
    
    $container.find("input[name='title']").on("input", function() {
        load();
    });

});