mod(".Uu8qdmPUCT").init(function() {

    var $container = $(this);
    
    $container.on("validate", function(event) {
        event.preventDefault();
        mod.call({
            cmd: "infuso/useractions/controller/recovery/newpassword",
            password: event.formData.password,
            token: $container.attr("data:token")
        }, function(html) {
            $container.find(".ajax-container").html(html);
        });
    });

    
});