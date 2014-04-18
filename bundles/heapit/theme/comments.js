$(function() {
    $(".comments-ckvopjhgwq").mod("init",function() {
        var container = $(this).find(".items");
        var parent = $(this).attr("data:parent");
        var updateComments = function(){
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
    });
});