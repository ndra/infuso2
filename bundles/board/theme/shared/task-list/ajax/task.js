$(function() {     
     
     $(".i95bnu5fvm").mod("init", function() {
     
        $(this).click(function() {
            var id = $(this).attr("data:id");
            mod.fire("openTask",id);
        });
        
        $(this).on("dragstart", function(e) {
            e.originalEvent.dataTransfer.setData("task-id", $(this).attr("data:id"));
        });
     
        $(this).mouseenter(function() {
            $(this).find(".tools").animate({
                top: 0
            }, "fast");
        });
        
        $(this).mouseleave(function() {
            $(this).find(".tools").animate({
                top: 45
            }, "fast");
        });
        
     });
         
});