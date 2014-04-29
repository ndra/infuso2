$(function() {

    var loadTaksForBlock = function(taskListBlock) {
        var block = $(taskListBlock);
        var itemsList = block.find(".ajax-container");
        var loader =  block.find(".loader");
        itemsList.html("");
        loader.show();
        var data = {};
        block.find(".c-toolbar").trigger("beforeLoadTaks", {block:block, data:data});
        var blockClass = block.attr("class").split(" ");
        var unique = blockClass[1];
        data.cmd = "Infuso/Board/Controller/Task/getTasks";
        mod.call(data, function(data) {
            loader.hide();
            itemsList.html(data.html);
            var pagerdata = {block: block, data: data}
            block.find(".c-toolbar").trigger("collection-loaded", pagerdata);
        }, {
            unique: unique
        });
        
    }
    
    $(".task-list-rpu80rt4m0").each(function(){
        $(this).on("taskFilterChanged", function(event, params){
            event.stopPropagation();
            loadTaksForBlock(this);         
        });      
    });
    
    var loadTasksForAllBlock = function() {
        $(".task-list-rpu80rt4m0").each(function(){
            loadTaksForBlock(this);
        });    
    }
    
    setTimeout(loadTasksForAllBlock,0);
    
    // При нажатии на F5 перегружаем список задач
    
    $(document).keydown(function(event) {
        if(event.which === 116) {
            loadTasksForAllBlock();
            event.preventDefault();
        }
    });

}); 