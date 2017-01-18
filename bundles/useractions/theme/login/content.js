mod(".Y8y9HPBfXA").init(function() {

    var $container = $(this);
    
    $container.on("submit", function(event) {
        event.preventDefault();
        mod.call({
            cmd: "infuso/useractions/controller/login/login",
            data: mod($container).formData()
        }, function(ret) {
            if(!ret) {
                $container.find(".error").show("fast");
            } else {
                window.location.href = "/";
            }
        });
    });

    
});