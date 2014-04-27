$(function() {

    $(".task-list-zjnu1r2ofp .task").mod("init", function() {
    
        var task = $(this);
        task.click(function() {
            var id = task.attr("data:id");
            mod.fire("openTask",id);
        });
        
    });
    
    var list = $(".task-list-zjnu1r2ofp").get(0);
    new Sortable(list, {
        onUpdate: function() {
            mod.msg("sort complete");
        }
    }); 

});