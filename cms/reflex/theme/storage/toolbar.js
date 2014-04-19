$(function() {

    $(".x8gdq98zre1").mod("init", function() {
    
        var container = $(".x8gdq98zre1");
        var file = container.find("input[type=file]");
        var editor = container.attr("infuso:editor");
        
        file.change(function() {
            mod.call({
                cmd:"infuso/cms/reflex/controller/storage/upload",
                editor:editor
            },function() {
                mod.fire("reflex/storage/upload");
            },{
                files: container
            });
        });
        
    });

})