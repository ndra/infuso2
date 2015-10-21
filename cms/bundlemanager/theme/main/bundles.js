mod.init(".erjk605ygl", function() {
  
    var $container = $(this);
    
    $container.tree({});

    $container.find(".files").click(function() {
        var bundle = $(this).attr("data:bundle");
        mod.fire("bundlemanager/open-files", {
            bundle:bundle
        });
    });
    
    $container.find(".theme").click(function() {
        var theme = $(this).attr("data:theme");
        mod.fire("bundlemanager/open-theme", {
            theme:theme
        });
    });

});