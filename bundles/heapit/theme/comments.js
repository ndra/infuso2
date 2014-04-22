$(function() {
    /*$(".comments-ckvopjhgwq").mod("init",function() {
        var container = $(this).find(".items");
        var parent = $(this).attr("data:parent");
        var updateComments = function() {
            mod.call({
                cmd: "infuso/heapit/controller/comments/list",
                parent: parent
            }, function(html) {
                container.html(html);
            });    
        }
        updateComments();
        mod.on("comments/update-list", function() {
            updateComments();    
        });
    });*/
    
    var load = function() {
        var data = {};
        mod.fire("beforeLoadCollection", data);
        var itemsList = $(".comments-ckvopjhgwq .items");
        data.cmd = "Infuso/Heapit/Controller/Payment/search";
        data.parent = $(".comments-ckvopjhgwq").attr("data:parent");
        data.cmd = "Infuso/Heapit/Controller/Comments/search";   
        mod.call(data, function(data) {
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