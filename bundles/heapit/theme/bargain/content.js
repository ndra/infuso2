$(function() {

    $(".bairgain-item-s0jioq8htr").submit(function(e) {        
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/heapit/controller/bargain/save",
            bargainId: $(this).attr("data:bargainid"),
            data:data
        });
    });

});