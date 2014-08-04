mod.init(".ij0BvYHLIj", function() {
   
    $container = $(this);
    
    $container.find("input[name='title']").on("input", function() {
        mod.msg("search");
    });

});