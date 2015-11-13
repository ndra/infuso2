mod.init(".mQ2bn91Yw", function() {
   
   var $container = $(this);
   
    $search = $container.find(".search");
    
    $container.layout();
    
    var page = 1
    
    $container.on("reflex/setPage", function(e) {
        page = e.page;
        load();
    });
   
    var load = function() {
        mod.call({
            cmd: "infuso/cms/reflex/controller/field/linksAddItems",
            editor: $container.attr("data:editor"),
            field: $container.attr("data:field"),
            search: $search.val(),
            page: page
        }, function(html) {
            $container.find(".ajax").html(html);
        })
    };
    
   // load();
    
    $search.on("input", load);
   
});