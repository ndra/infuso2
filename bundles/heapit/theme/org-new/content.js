mod(".krziax51l6").init(function() {
    
    var $container = $(this);
    $container.submit(function(e) {
        e.preventDefault();
        var data = mod(this).formData();
        mod.call({
            cmd:"infuso/heapit/controller/org/new",
            data:data
        }, function(ret) {
            if(ret) {
                window.location.href = ret;
            }
        })
    });

});