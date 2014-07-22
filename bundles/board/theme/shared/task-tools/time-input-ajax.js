mod.init(".w3T2t7XKGU", function() {
    
    var $container = $(this);
    $container.submit(function(event) {
        event.preventDefault();
        var data = $container.mod("formData");
        console.log(data);
    });
    
});