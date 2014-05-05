$(function() {

    $(".task-toolbar-s88w4h5tpq").mod("init", function() {
    
        var container = $(this);

        container.find(".quicksearch").on("input", function() {
            $(this).trigger("task/filter-changed");
        });
        
        container.find(".pager").on("change", function() {
            $(this).trigger("task/filter-changed");
        });
        
        // Событие до загрузки
        // Добавляем в запрос поисковую строку и текущую страницу
        container.on("task/beforeLoad", function(event) {
            event.callData.search = container.find(".quicksearch").val();
            event.callData.page = container.find("input[name=pager]").val();
        });
        
        container.on("task/load", function(event) {
            container.find(".pager").pager("total", event.ajaxData.pages);
        });

    });
    
});