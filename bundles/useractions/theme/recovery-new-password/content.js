mod(".Uu8qdmPUCT").init(function() {

    var $container = $(this);
    
    $container.on("validate", function(event) {
        event.preventDefault();
        /*mod.call({
            cmd: "infuso/useractions/controller/recovery/send",
            email: event.formData.email
        }, function(html) {
            $container.find(".ajax-container").html(html);
        }); */
    });

    
});