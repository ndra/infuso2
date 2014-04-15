$(function() {

    var load = function() {
        
        var data = {};
        mod.fire("beforeLoadOrgs", data);
        data.cmd = "Infuso/Heapit/Controller/Bargain/search";
    
        mod.call(data, function(html) {
            $(".od655esqwh .items").html(html);
        }, {
            unique: "od655esqwh"
        });
        
    }
    
    mod.on("orgFilterChanged",load);
    
    setTimeout(load,0);

}); 