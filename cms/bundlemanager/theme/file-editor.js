mod.init(".y1esl75wqs", function() {

    var $container = $(this);

    var id = $(this).find(".editor").attr("id");
    var editor = ace.edit(id);
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");
    
    // При ресайзе окна запускаем отложенеый ресайз редактора
    // @todo переписать по-человечески
    $(window).resize(function() {
        setTimeout(function() {
            editor.resize();
        });
    });
    
    $(this).mod("on","keydown", function(e) {
    
        if(!$container.filter(":visible").length) {
            return;
        }
    
        if(e.which == 83 && e.ctrlKey) {
            mod.msg(editor.getValue());
            e.preventDefault();
        }
    });
    
});