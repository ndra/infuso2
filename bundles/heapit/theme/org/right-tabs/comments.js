$(function() {
    $(".vlk5bx6x1q").mod("init",function() {
        var container = $(this).find(".items");
        var orgId = $(this).attr("org:id");
        var updateComments = function(){
            mod.call({
            cmd: "infuso/heapit/controller/comments/list",
            orgId: orgId
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