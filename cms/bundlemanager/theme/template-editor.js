mod.init(".aivh9q8neu", function() {

    var $container = $(this);
    
    $container.layout();

    var selectTab = function(n) {
    
        $container.find(".top").children().each(function(i) {
            if(i==n) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
        
        $container.find(".center").children().each(function(i) {
            if(i==n) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    
    };
    
    selectTab(0);
    
    $container.find(".top").children().each(function(n) {
        $(this).click(function() {
            selectTab(n);
        });
    });
    
    $container.find(".center").children().each(function(n) {

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