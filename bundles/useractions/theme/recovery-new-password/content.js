mod(".Uu8qdmPUCT").init(function() {

    var $container = $(this);
    
    $container.on("validate", function(event) {
        event.preventDefault();
        mod.call({
            cmd: "infuso/useractions/controller/recovery/newpassword",
            email: event.formData.email
        }, function(html) {
            //$container.find(".ajax-container").html(html);
            mod.msg("success");
        });
    });

    
});