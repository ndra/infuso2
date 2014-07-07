$(function() {

    var $container = $(".v1rP7KWp0y");

    $container.find(".login").click(function() {
        mod.call({
            cmd: "infuso/cms/user/controller/loginAs",
            userId: $container.attr("data:userid")
        });
    });
    
});