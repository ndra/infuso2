$(function() {

    mod.on("bundlemanager/open-files", function(params) {
        mod.call({
            cmd: "infuso/cms/bundlemanager/controller/files/right",
            bundle: params.bundle
        }, function(ret) {
            $(".s1i95xmv40").html(ret)
        });
    });
        
});