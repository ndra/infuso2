$(function() {

    // Загружает список элементов и выводит их на страницу
    var load = function() {
    
        var collection = $(".cjoesz8swu").attr("infuso:collection");
    
        var params = {
            cmd:"infuso/cms/reflex/controller/getItems",
            collection:collection
        };
    
        mod.fire("reflex/beforeLoad",params);
        
        mod.call(params, function(ret) {
            $(".cjoesz8swu").html(ret.html);
        });
    }
    
    load();
    
    mod.on("reflex/refresh",load);
    
    $(document).on("keydown",function(e) {
        if(e.keyCode == 116 && !e.ctrlKey) {
            load();
            e.preventDefault();
        }
    })

});