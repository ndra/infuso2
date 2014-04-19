$(function() {

    $(".logout").click(function() {
        mod.call({
            cmd: "infuso/user/controller/logout"
        },function() {
            window.location.reload();
        })
    });

});