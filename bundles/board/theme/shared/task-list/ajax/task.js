$(function() {

     /*$(".i95bnu5fvm").on("dragstart", function(e) {
         e.originalEvent.dataTransfer.setData("task-id", $(this).attr("data:id"));
     });*/ 
     
     mod.msg($(".i95bnu5fvm").length);
     
     $(".i95bnu5fvm").mod("init", function() {
     
        mod.msg(2);
     
        $(this).mouseenter(function() {
            $(this).find(".tools").fadeIn();
        });
        
        $(this).mouseenter(function() {
            $(this).find(".tools").fadeOut();
        });
        
     });
         
});