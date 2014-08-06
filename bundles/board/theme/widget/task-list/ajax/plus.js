mod.init(".Y54PCKLOIE", function() {
    
    var $container = $(this);
    
    $(this).click(function() {
        $(this).trigger({
            type: "board/newTask",
            groupId: $container.attr("data:group")
        });
    })
})