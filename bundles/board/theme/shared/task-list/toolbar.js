$(function(){
    $(".task-toolbar-s88w4h5tpq .quicksearch").on("input", function() {
        $(this).trigger("taskFilterChanged");
    });
    
    $(".task-toolbar-s88w4h5tpq input[type=checkbox]").on("change", function() {
        $(this).trigger("taskFilterChanged");
    });
    
    $(".task-toolbar-s88w4h5tpq .pager").on("change", function() {
        $(this).trigger("taskFilterChanged");
    });
    
    $(".task-toolbar-s88w4h5tpq.c-toolbar").on("beforeLoadTaks", function(event, params){
        var filter = params.data;
        var block =  $(params.block);
        filter.search = block.find(".quicksearch").val();
        filter.projects = block.find("input[type=checkbox]:checked").map(function(_, el) { return $(el).val() }).get();  
        filter.page = block.find("input[name=pager]").val(); 
    });
    
    $(".task-toolbar-s88w4h5tpq.c-toolbar").on("collection-loaded", function(e,params) {
        var data = params.data;
        var block = $(params.block);
        block.find(".c-toolbar").pager("total", data.total);
    });
    
});