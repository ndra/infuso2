$(function() {

    $(".payment-20xbo3sykg").submit(function(e) {        
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd: "infuso/heapit/controller/payment/save",
            paymentId: $(this).attr("data:paymentid"),
            data:data
        });
    });

});