$(function() {
   
    var list = $(".task-list-zjnu1r2ofp").get(0);
    new Sortable(list, {
        onUpdate: function() {
            mod.msg("sort complete");
        }
    }); 

});