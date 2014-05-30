mod.init(".y1esl75wqs", function() {

    var id = $(this).find(".editor").attr("id");
    var editor = ace.edit(id);
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");
    
    // @todo переделать по человечески
    setInterval(function() {
        editor.resize();
    }, 1000);

});