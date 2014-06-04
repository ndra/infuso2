mod.init(".aivh9q8neu", function() {

    var $container = $(this);
    var $tabs = $container.find(".tabs").children();
    var $tabsContent = $container.find(" > .center").children();
    
    $container.layout();

    var selectTab = function(n) {
    
        $tabs.each(function(i) {
            if(i==n) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
        
        $tabsContent.each(function(i) {
            if(i==n) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        var id = $tabsContent.filter(".editor:visible").attr("id");
        ace.edit(id).focus();
    
    };
    
    selectTab(0);
    
    $tabs.each(function(n) {
        $(this).click(function() {
            selectTab(n);
        });
    });
    
    $container.find(".top .functions").click(function() {
        var id = $tabsContent.filter(".editor:visible").attr("id");
        var makeid = function() {
        
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        
            for( var i=0; i < 10; i++ )
                text += possible.charAt(Math.floor(Math.random() * possible.length));
        
            return text;
        }
        ace.edit(id).insert(makeid());
    });
    
    $tabsContent.each(function(n) {

        var id = $(this).attr("id");
        var editor = ace.edit(id);
        var $editor = $(this);
        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/" + $editor.attr("data:lang"));

        $editor.on("layoutchange", function() {
            editor.resize();
        });
        
        
        $(this).mod("on","keydown", function(e) {
       
            if(!$editor.filter(":visible").length) {
                return;
            }
            
            if(e.which == 27) {
                var id = $tabsContent.filter(".editor:visible").attr("id");
                ace.edit(id).focus();
            }
        
            if(e.which == 83 && e.ctrlKey) {
                e.preventDefault();
                var value = editor.getValue();
                var theme = $container.attr("data:theme");
                var template = $container.attr("data:template");
                mod.call({
                    cmd: "infuso/cms/bundlemanager/controller/theme/save",
                    theme: theme,
                    template: template,
                    type: $editor.attr("data:type"),
                    content: value
                });
            }
        });
    
    });


});