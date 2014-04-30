$(function() {

    var load = function() {
        var loader = $(".payments-list-j5mafyccpm .loader");
        var itemsList = $(".payments-list-j5mafyccpm .items");
        loader.show();
        var data = {};
        mod.fire("beforeLoadCollection", data);
        data.cmd = "Infuso/Heapit/Controller/Payment/search";
        data.orgId = $(".payments-list-j5mafyccpm").attr("data:orgId");
        mod.call(data, function(data) {
            loader.hide();
            itemsList.html(data.html);
            $(".payments-list-j5mafyccpm .c-toolbar").trigger("collection-loaded", data);
        }, {
            unique: "j5mafyccpm"
        });
        
    }
    
    mod.on("collectionFilterChanged",load);
    $(window).on("focus", load);
    
    setTimeout(load,0);

}); 