mod.init(".YkELjC2q38", function() {
    
    // Нажатие на задачу
    $(this).find(".back").click(function(event) {
        $(this).trigger({
            type: "board/openGroup",
            groupId: 0
        });    
    });
    
});