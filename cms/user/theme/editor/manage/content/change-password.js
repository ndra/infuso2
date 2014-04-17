$(function() {

    var container = $(".hk5yt7oqut");

    container.find(".change").click(function() {
        container.find(".change-form").show();
        container.find(".change").hide();
    });
    
    container.find(".cancel").click(function() {
        container.find(".change-form").hide();
        container.find(".change").show();
    });
    
    container.find(".save").click(function() {
    
        var p1 = container.find("input[name=password]").val();
        var p2 = container.find("input[name=passwordConfirmation]").val();
        
        if(p1 != p2) {
            mod.msg("Пароль и подтверждение на совпадают", 1);
            return;
        }
    
        mod.call({
            cmd: "infuso/cms/user/controller/changePassword",
            password: p1
        }, function(ret) {
            if(ret) {
                container.find(".change-form").hide();
                container.find(".change").show();
            }
        });

    });

});