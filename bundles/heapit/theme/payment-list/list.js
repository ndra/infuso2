$(function() {

    var load = function() {
        var loader = $(".payments-list-j5mafyccpm .loader");
        var itemsList = $(".payments-list-j5mafyccpm .items");
        itemsList.html("");
        loader.show();
        var data = {};
        mod.fire("beforeLoadCollection", data);
        data.cmd = "Infuso/Heapit/Controller/Payment/search";
    
        mod.call(data, function(data) {
            loader.hide();
            itemsList.html(data.html);
            $(".payments-list-j5mafyccpm .c-toolbar").trigger("collection-loaded", data);
        }, {
            unique: "j5mafyccpm"
        });
        
    }
    
    mod.on("collectionFilterChanged",load);
    
    setTimeout(load,0);

}); 