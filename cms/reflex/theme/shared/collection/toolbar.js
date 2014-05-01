$(function() {

    var container = $(".qoi8w451jl");

    // Изменение режима просмотра
    $(".qoi8w451jl select[name='viewMode']").change(function() {
        $(this).trigger("reflex/refresh");
    });
    
    // Быстрый поиск
    $(".qoi8w451jl input[name='query']").on("input", function() {
        container.trigger("reflex/refresh");
    });
    
    // Учет параметров фильтра перед загрузкой

    mod.on("reflex/beforeLoad",function(p) {    
        p.viewMode = $(".qoi8w451jl select[name='viewMode']").val();
        p.query = $(".qoi8w451jl input[name='query']").val();
    });
    
    // Создание элемента
    
    $(".qoi8w451jl .create").click(function() {
        var container = $(this).parents(".qoi8w451jl");
        var collection = container.attr("infuso:collection");
        mod.call({
            cmd:"infuso/cms/reflex/controller/create",
            collection:collection
        },function(url) {
            window.location.href = url;
        });
    });
    
    // реагируем на смену выделения    
    
    var sel = [];
    
    $(".qoi8w451jl").on("selectionChanged", function(e, selection) {
        $(this).find(".selection-info").html("Выбрано: " + selection.length);
        var container = $(this).find(".with-selected");
        if(selection.length > 0) {
            container.animate({opacity:1});
        } else {
            container.animate({opacity:0});
        }
        sel = selection;
    });
    

    $(".qoi8w451jl .delete").click(function() {
    
        if(!confirm("Удалить выбранные объекты")) {
            return;
        }
    
        mod.call({
            cmd:"infuso/cms/reflex/controller/delete",
            items: sel
        }, function() {
            container.trigger("reflex/refresh");   
        });        
    })

});