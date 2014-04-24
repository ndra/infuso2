$(function() {

    var load = function() {
        var loader = $(".task-list-layout-32tvfkepng .loader");
        var itemsList = $(".task-list-layout-32tvfkepng .items");
        itemsList.html("");
        loader.show();
        var data = {};
        //mod.fire("beforeLoadCollection", data);
        data.cmd = "Infuso/Board/Controller/Task/getTasks";
        data.status = $(".task-list-layout-32tvfkepng").attr("tasks:status")
        mod.call(data, function(data) {
            loader.hide();
            itemsList.html(data.html);
            //$(".od655esqwh .c-toolbar").trigger("collection-loaded", data);
        }, {
            unique: "32tvfkepng"
        });
        
    }
    
    mod.on("load-task-list",load);
    
    setTimeout(load,0);

}); 