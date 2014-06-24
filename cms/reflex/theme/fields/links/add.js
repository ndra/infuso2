mod.init(".mQ2bn91Yw", function() {
   
   var $container = $(this);
   $container.click(function(event) {
        var id = $(event.target).attr("data:id");
        if(id) {
            $container.window().trigger({
                type: "links/select",
                itemID: id,
                title: $(event.target).text()
            });
            $container.window("close");
        }
   });
   
    
});