$(function() {

    $(".payment-form-rxuwp132pd").submit(function(e) {
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/heapit/controller/payment/new",
            data:data
        })
    });

});