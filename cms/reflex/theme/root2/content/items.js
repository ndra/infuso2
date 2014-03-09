$(function() {

    // Загружает список элементов и выводит их на страницу
    var load = function() {
    
        var collection = $(".cjoesz8swu").attr("infuso:collection");
        mod.cmd({
            cmd:"infuso/cms/reflex/controller/getItems",
            collection:collection
        }, function(ret) {
            $(".cjoesz8swu").html(ret.html);
        });
    }
    
    load();

});