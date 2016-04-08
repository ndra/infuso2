$(function() {

    $(".iv09v31m1i").submit(function(e) {
        e.preventDefault();
        mod.call({
            cmd:"infuso/board/controller/conf/save",
            data: mod(".iv09v31m1i").formData()
        });
    });

});