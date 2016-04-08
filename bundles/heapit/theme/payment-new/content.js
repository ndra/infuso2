$(function() {

    $(".aqzdqv7jjr").submit(function(e) {
        e.preventDefault();
        var data = mod(this).formData();
        mod.call({
            cmd:"infuso/heapit/controller/payment/new",
            data:data
        }, function(url) {
            if(url) {
                window.location.href = url;
            }
        });
    });

});