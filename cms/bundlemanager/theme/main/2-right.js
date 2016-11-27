mod.init(".s1i95xmv40", function() {
    
    var $container = $(this);
    
    var selectTab = function(key) {
        var $tab = $(null);
        $container.children().each(function() {
            if($(this).data("key") == key) {
                $tab = $(this);
            }
        });
        
        if($tab.length) {
            $container.children().hide();
            $tab.show();
        }
        
        return $tab;
        
    }
    
    var setTab = function(key, html) {
        
        $container.children().hide();
        
        var $tab = $("<div>")
            .data("key", key)
            .css("position", "relative")
            .css("height", "100%")
            .html(html)
            .appendTo($container);
    }
    
    mod.on("bundlemanager/open-files", function(params) {
        var key = "files:" + params.bundle;
        var $tab = selectTab(key);
        if(!$tab.length) {
            mod.call({
                cmd: "infuso/cms/bundlemanager/controller/files/right",
                bundle: params.bundle
            }, function(ret) {
                setTab(key, ret);
            });
        }
    });
    
    mod.on("bundlemanager/open-theme", function(params) {
        var key = "theme:" + params.theme;
        var $tab = selectTab(key);
        if(!$tab.length) {
            mod.call({
                cmd: "infuso/cms/bundlemanager/controller/theme/right",
                theme: params.theme
            }, function(ret) {
                setTab(key, ret);
            });
        }
    });
        
});