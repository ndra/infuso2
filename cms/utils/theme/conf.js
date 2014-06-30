mod.init(".am2bKLBsQW", function() {

    var $container = $(this);

    var id = $(this).find(".editor").attr("id");
    var editor = ace.edit(id);
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");
    
    // Ctrl+S для сохранения
    $(this).mod("on","keydown", function(e) {
        if(e.which == 83 && e.ctrlKey) {
            mod.msg(editor.getValue());
            e.preventDefault();
        }
    });
    
});