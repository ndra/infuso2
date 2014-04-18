$(function() {

    var container = $(".zrtlp4pj2i");
    
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
    
        var userId = container.attr("data:userid");
        var role = container.find(".role-select").val();
        mod.call({
            
        })
    
    });

});