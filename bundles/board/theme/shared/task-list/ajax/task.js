$(function() {
     $(".i95bnu5fvm").on("dragstart", function(e) {
         e.originalEvent.dataTransfer.setData("task-id", $(this).attr("data:id"));
     });     
});