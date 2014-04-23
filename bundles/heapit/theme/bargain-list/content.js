$(function() {

    var load = function() {
        var loader = $(".od655esqwh .loader");
        var itemsList = $(".od655esqwh .items");
        itemsList.html("");
        loader.show();
        var data = {};
        mod.fire("beforeLoadCollection", data);
        data.cmd = "Infuso/Heapit/Controller/Bargain/search";
    
        mod.call(data, function(data) {
            loader.hide();
            itemsList.html(data.html);
            $(".od655esqwh .c-toolbar").trigger("collection-loaded", data);
        }, {
            unique: "od655esqwh"
        });
        
    }
    
    mod.on("collectionFilterChanged",load);
    
    setTimeout(load,0);

}); 