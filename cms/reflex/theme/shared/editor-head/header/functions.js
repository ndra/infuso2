mod.init(".pn2dSKDht6", function() {
    
    $(this).find(".view").click(function() {
        window.open($(this).attr("data:url"));
    });
    
    $(this).find(".delete").click(function() {
        
        if(!confirm("Удалить объект?")) {
            return;
        }
        
        mod.call({
            cmd: "infuso/cms/reflex/controller/delete",
            items: [$(this).attr("data:id")]
        }, function(url) {
            if(url) {
                window.location.href = url;    
            }
        });
    });
    
});