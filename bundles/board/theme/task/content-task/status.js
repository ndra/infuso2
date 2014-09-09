mod.init(".mnynzim4sj", function() {

    var $container = $(this);
    
    mod.on("board/taskChanged", function(data) {
        $container.find(".status-text").html(data.statusText)
    });
    
    $container.click(function() {
        $.window({
            title: "Выбор проекта",
            call: {
                cmd: "infuso/board/controller/project/selectorWindowContent"
            }
        });
    });

})