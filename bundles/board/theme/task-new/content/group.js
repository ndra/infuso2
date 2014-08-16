mod.init(".XodEbnBfVK", function() {

    var $container = $(this);
    
    $container.on("submit", function(event) {
        event.preventDefault();
        mod.call({
            cmd: "infuso/board/controller/task/createGroup",
            parent: $container.attr("data:group"),
            text: $container.find("[name=text]").val()
        });
    })

});