mod(".zrtlp4pj2i").init(function() {

    var container = $(this);
    
    container.find(".remove").click(function() {
        var role = $(this).attr("data:role");
        mod.call({
            cmd: "infuso/cms/user/controller/removeRole",
            userId: container.attr("data:userid"),
            role: role   
        }, function(ret) {
            if(ret) {
                container.trigger("updateRoles");
            }
        })
    })
    
    var showForm = function() {
        container.find(".add").hide();
        container.find(".add-role-container").show();
    };
    
    var hideForm = function() {
        container.find(".add").show();
        container.find(".add-role-container").hide();
    };
    
    container.find(".add").click(showForm);
    
    container.find(".cancel").click(hideForm);
    
    container.find(".ok").click(function() {
        mod.call({
            cmd: "infuso/cms/user/controller/addRole",
            userId: container.attr("data:userid"),
            role: container.find(".role-select").val()   
        }, function(ret) {
            if(ret) {
                container.trigger("updateRoles");
            }
        });
    });

});