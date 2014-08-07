mod.init(".cjoesz8swu", function() {

    var $container = $(this);

    // Загружает список элементов и выводит их на страницу
    var load = function() {
    
        var collection = $container.attr("infuso:collection");
    
        var params = {
            cmd:"infuso/cms/reflex/controller/getItems",
            collection:collection
        };
        
        $container.find(" > .loader").show();
    
        mod.fire("reflex/beforeLoad",params);
        
        mod.call(params, function(ret) {
            $container.find(".ajax").html(ret.html);
            $container.find(" > .loader").hide();
        }, {
            unique: "ui7605fvbl"
        });
    }
    
    load();
    
    $container.on("reflex/refresh", load);
    
    $container.on("reflex/deselect", function() {
        $(this).list("deselect");
    });
    
    $(document).on("keydown",function(e) {
        if(e.keyCode == 116 && !e.ctrlKey) {
            load();
            e.preventDefault();
        }
    })

});