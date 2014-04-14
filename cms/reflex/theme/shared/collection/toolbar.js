$(function() {

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
        $(this).find(".selection-info").html("Выбрано элементов: " + selection.length);
    })

});