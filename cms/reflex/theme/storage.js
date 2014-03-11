$(function() {

    var load = function() {
    
        var container = $(".x0jgagz44k7");    
        var editor = $(".x0jgagz44k7").attr("infuso:editor");        
    
        mod.call({
            cmd:"infuso/cms/reflex/controller/storage/getFiles",
            editor: editor,
        },function(p) {
            container.find(".files").html(p.html);
        })
    
    }
    
    load();
    mod.on("reflex/storage/upload",load);

});