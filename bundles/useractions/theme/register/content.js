mod(".dAjO02CzQJ").init(function() {

    var $container = $(this);
    
    $container.on("validate", function(event) {
        event.preventDefault();
        mod.call({
            cmd: "infuso/useractions/controller/register/register",
            data: event.formData
        }, function(html) {
            $container.find(".ajax-container").html(html);
        });
        
    });

    
});