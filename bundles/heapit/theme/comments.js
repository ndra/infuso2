$(function() {
    
    var load = function() {
        var loader = $(".comments-ckvopjhgwq .loader");
        var itemsList = $(".comments-ckvopjhgwq .items");
        itemsList.html("");
        loader.show();
        var data = {};
        mod.fire("beforeLoadCollection", data);
        data.cmd = "Infuso/Heapit/Controller/Payment/search";
        data.parent = $(".comments-ckvopjhgwq").attr("data:parent");
        data.cmd = "Infuso/Heapit/Controller/Comments/search";   
        mod.call(data, function(data) {
            loader.hide();
            itemsList.html(data.html);
            $(".comments-ckvopjhgwq .c-toolbar").trigger("collection-loaded", data);
        }, {
            unique: "j5mafyccpm"
        });
    }
    
    mod.on("collectionFilterChanged", load);
    
    mod.on("comments/update-list", load);
    
    setTimeout(load,0);
    
});