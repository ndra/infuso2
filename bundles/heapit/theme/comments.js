$(function() {
    
    var load = function() {
        var loader = $(".comments-ckvopjhgwq .loader");
        var itemsList = $(".comments-ckvopjhgwq .items");
        itemsList.html("");
        loader.show();
        var data = {};
        mod.fire("beforeLoadComments", data);
        data.cmd = "Infuso/Heapit/Controller/Payment/search";
        data.parent = $(".comments-ckvopjhgwq").attr("data:parent");
        data.cmd = "Infuso/Heapit/Controller/Comments/search";
        mod.call(data, function(data) {
            loader.hide();
            itemsList.html(data.html);
            $(".comments-ckvopjhgwq .c-toolbar").trigger("comments-loaded", data);
        }, {
            unique: "ckvopjhgwq"
        });
    }
    
    mod.on("commentsFilterChanged", load);
    
    mod.on("comments/update-list", load);
    
    setTimeout(load,0);
    
});