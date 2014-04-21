$(function() {

    var load = function() {
        
        var data = {};
        mod.fire("beforeLoadCollection", data);
        data.cmd = "Infuso/Heapit/Controller/Bargain/search";
    
        mod.call(data, function(data) {
            $(".od655esqwh .items").html(data.html);
            $(".od655esqwh .c-toolbar").trigger("collection-loaded", data);
        }, {
            unique: "od655esqwh"
        });
        
    }
    
    mod.on("collectionFilterChanged",load);
    
    setTimeout(load,0);

}); 