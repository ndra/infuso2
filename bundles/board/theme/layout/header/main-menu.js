$(function() {

    $(".x55qv4lhb8m .item").on("dragenter", function() {
        $(this).css({
            textDecoration: "underline"
        });
    });
    
    // Перетаскивание задачи в пункт меню (смена статуса)
    $(".x55qv4lhb8m .item").on("drop", function(e) {
        mod.msg(e.originalEvent.dataTransfer.getData("task-id"));
    });
    
    // Подсветка активного пункта меню
    var check = function() {
    
        $(".tob-bar-sr3yrzht3j a").each(function() {
            if($(this).attr("href") != "#" && this.href == window.location.href) {
                $(this).addClass("active");
            }
        })
    
    }
    check();
    
});