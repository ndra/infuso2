$(function() {

    $(".d4itmgyx0b").on("updateRoles", function() {
    
        var container = $(this);
    
        mod.call({
            cmd: "infuso/cms/user/controller/getRolesAjax",
            userId: container.attr("data:userid")   
        }, function(html) {
            container.find(".ajax-container").html(html)
        });
    });

})