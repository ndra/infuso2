$(function() {

    $(".o64rds6rlp").submit(function(e) {        
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/heapit/controller/org/save",
            orgId: $(this).attr("data:orgid"),
            data:data
        });
    });

});