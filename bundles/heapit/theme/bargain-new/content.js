$(function() {

    $(".bargian-form-bsszqf8kse").submit(function(e) {
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/heapit/controller/bargain/new",
            data:data
        })
    });

});