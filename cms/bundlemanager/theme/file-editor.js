mod.init(".y1esl75wqs", function() {
    
    var $container = $(this);
    var $editor = $container.find(".editor");
    
    var id = $editor.attr("id");
    var editor = ace.edit(id);
    
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/" + $container.attr("data:lang"));

    $editor.on("layoutchange", function() {
        editor.resize();
    });
    
    $(this).mod("on","keydown", function(e) {
   
        if(!$editor.filter(":visible").length) {
            return;
        }
        
        if(e.which == 27) {
            editor.focus();
        }
    
        if(e.which == 83 && e.ctrlKey) {
            e.preventDefault();
            var value = editor.getValue();
            var path = $container.attr("data:path");
            mod.call({
                cmd: "infuso/cms/bundlemanager/controller/files/save",
                path: path,
                content: value
            });
        }
    });
    
});