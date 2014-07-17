mod.init(".XodEbnBfVK", function() {

    var $container = $(this);
    
    $container.on("submit", function(event) {
        event.preventDefault();
        mod.call({
            cmd: "infuso/board/controller/task/createGroup",
            text: $container.find("[name=text]").val()
        });
    })

});