mod.init(".mQ2bn91Yw", function() {
   
   var $container = $(this);
   $container.click(function(event) {
        var id = $(event.target).attr("data:id");
        var editUrl = $(event.target).attr("data:editUrl");
        if(id) {
            $container.window().trigger({
                type: "links/select",
                itemID: id,
                editUrl: editUrl,
                title: $(event.target).text()
            });
            $container.window("close");
        }
   });
   
    
});