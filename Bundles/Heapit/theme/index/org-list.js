$(function() {

    var load = function() {
        
        var data = {};
        mod.fire("beforeLoadOrgs", data);
        data.cmd = "Infuso/Heapit/Controller/Org/search";
    
        mod.call(data, function(html) {
            $(".ro33jkjt9t .items").html(html);
        }, {
            unique: "0p7cqqkuga"
        });
        
    }
    
    mod.on("orgFilterChanged",load);
    
    setTimeout(load,0);

}); 