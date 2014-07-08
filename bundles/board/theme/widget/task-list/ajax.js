$(function() {
   
    $(".task-list-zjnu1r2ofp").mod("init", function() {
        new Sortable(this, {
            draggable: ".task",
            onUpdate: function() {
                mod.msg("sort complete");
            }
        }); 
    });

});