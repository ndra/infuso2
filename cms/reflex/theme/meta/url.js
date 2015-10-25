mod.init(".i5stoh804p", function() {

    var $container = $(this);
    
    var load = function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/route/getcontent",
            editor: $container.attr("data:editor")
        }, function(data) {
            $container.html(data);
        });
    };
    
    $container.on("route/reload", load);

});