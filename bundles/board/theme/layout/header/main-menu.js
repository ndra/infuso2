$(function() {

    $(".x55qv4lhb8m .item").on("dragenter", function() {
        $(this).css({
            textDecoration: "underline"
        });
    });
    
    $(".x55qv4lhb8m .item").on("drop", function(e) {
        mod.msg(e.originalEvent.dataTransfer.getData("task-id"));
    });

});