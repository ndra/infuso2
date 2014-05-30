$(function() {

    $(".erjk605ygl .files").click(function() {
        var bundle = $(this).attr("data:bundle");
        mod.fire("bundlemanager/open-files", {
            bundle:bundle
        });
    });
    
    $(".erjk605ygl .theme").click(function() {
        var theme = $(this).attr("data:theme");
        mod.fire("bundlemanager/open-theme", {
            theme:theme
        });
    });

});