$(function() {

    $(".qoi8w451jl select[name='viewMode']").change(function() {
        $(this).trigger("reflex/refresh");
    });

    // Учет параметров фильтра перед загрузкой

    mod.on("reflex/beforeLoad",function(p) {    
        p.viewMode = $(".qoi8w451jl select[name='viewMode']").val();
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
    
    $(".qoi8w451jl").on("selectionChanged", function(e, selection) {
        $(this).find(".selection-info").html("Выбрано: " + selection.length);
        var container = $(this).find(".with-selected");
        if(selection.length > 0) {
            container.animate({opacity:1});
        } else {
            container.animate({opacity:0});
        }
    });
    

    $(".qoi8w451jl .delete").click(function() {
        $(this).trigger("reflex/refresh");
    })

});