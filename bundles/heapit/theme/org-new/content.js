$(function() {

    $(".krziax51l6").submit(function(e) {
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/heapit/controller/org/new",
            data:data
        }, function(ret) {
            if(ret) {
                window.location.href = ret;
            }
        })
    });

});