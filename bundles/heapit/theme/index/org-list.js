$(function() {

    var load = function() {
        var loader = $(".ro33jkjt9t .loader");
        var itemsList = $(".ro33jkjt9t .items");
        itemsList.html("");
        loader.show();
        var data = {};
        mod.fire("beforeLoadOrgs", data);
        data.cmd = "Infuso/Heapit/Controller/Org/search";
    
        mod.call(data, function(data) {
            loader.hide();
            $(".ro33jkjt9t .items").html(data.html);
            $(".ro33jkjt9t .c-toolbar").trigger("collection-loaded", data);
        }, {
            unique: "0p7cqqkuga"
        });
        
    }
    
    mod.on("orgFilterChanged",load);
    
    setTimeout(load,0);

}); 