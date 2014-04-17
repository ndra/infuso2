$(function() {

    $(".ms3hpuzlzi").submit(function(e) {
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/heapit/controller/bargain/new",
            data:data
        }, function(url){
            window.location.href = url;
        })
    });

});