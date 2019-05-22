mod.init(".iFp4vhXrrS", function() {

    var $container = $(this);
    
    var load = function() {
        mod.call({
            cmd: "infuso/site/model/batterycalculator/cell/updatePrice",
            id: $container.attr("data:id")
        }, function(html) {
            $container.find(".ajax-container").html(html)
        });
    };
    
    load();
    
    $container.on("submit", function(event) {
        event.preventDefault();
        var data = mod($container.find("form")).formData();
        mod.call({
            cmd: "infuso/site/model/batterycalculator/cell/savePrice",
            data: data,
            id: $container.attr("data:id")
        }, load);
    });
    
});