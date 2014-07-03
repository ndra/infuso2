mod.init(".am2bKLBsQW", function() {

    var $container = $(this);

    var id = $(this).find(".editor").attr("id");
    var editor = ace.edit(id);
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/yaml");
    
    var save = function() {
        var data = editor.getValue();
        mod.call({
            cmd: "infuso/cms/utils/conf/save",
            data: data
        })
    };
    
    $container.find(".save").click(save);
    
    // Ctrl+S для сохранения
    $(this).mod("on","keydown", function(e) {
        if(e.which == 83 && e.ctrlKey) {
            save();
            e.preventDefault();
        }
    });
    
});