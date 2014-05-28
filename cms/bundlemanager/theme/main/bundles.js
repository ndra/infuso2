$(function() {

    $(".erjk605ygl .files").click(function() {
        var bundle = $(this).attr("data:bundle");
        mod.fire("bundlemanager/open-files", {
            bundle:bundle
        });
    });

});