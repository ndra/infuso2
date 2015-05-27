mod.init(".ij0BvYHLIj", function() {
   
    var $container = $(this);
    
    var $input = $container.find("input[name='title']");
    
    var load = function() {
        mod.call({
            cmd:"infuso/board/controller/widgets/projectSelector",
            query: $input.val()
        }, function(data) {
            $container.find(".ajax").html(data.html);
        });
    }
    
    $input.on("input", function() {
        load();
    });

});