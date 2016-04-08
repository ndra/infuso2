mod.init(".jLuIIGVTPp", function() {
    
    $container = $(this);
    $container.submit(function(event) {
        event.preventDefault();
        var data = mod($container).formData();
        mod.call({
            cmd:"infuso/board/controller/project/new",
            data:data
        }, function(url){
            window.location.href = url;
        });
    });
    
});