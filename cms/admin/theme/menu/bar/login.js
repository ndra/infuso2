mod.init(".nqalth29om", function() {

    var $container = $(this);
    
    var logout = $(this).find(".logout");

    logout.click(function(){
        mod.call({cmd:"infuso/user/controller/logout"}, function(){
            location.reload();
        });
    });

});