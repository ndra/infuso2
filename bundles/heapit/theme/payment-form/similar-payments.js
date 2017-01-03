mod(".J94g6FIowv").init(function() {

    var $container = $(this);
    $container.on("refresh", function(event) {
        mod.call({
            cmd: "infuso/heapit/controller/payment/similar",
            paymentId: $container.attr("data:id"),
            date: event.date
        }, function(html) {
            $container.find(".ajax-container").html(html);
        }, {
            unique: "nCyQhgQRZn"
        })
    });
    
});