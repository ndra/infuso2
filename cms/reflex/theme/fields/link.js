mod.init(".x4qRpzOJXG", function() {
    
    var $container = $(this);
    
    $container.find(".title, .title-void").click(function() {
        $.window({
            title: "Выберите элемент",
            width: 600,
            height: 400,
            call:{ 
                cmd: "infuso/cms/reflex/controller/field/linksAdd",
                editor: $container.attr("data:editor"),
                field: $container.attr("data:field"),
            }
        }).on("links/select", function(event) {
            $container.find("input").val(event.itemID);
            $container.find(".title").show().text(event.title);
            $container.find(".title-void").hide();
            $container.find(".view").show().attr("href", event.editUrl);
            $container.find(".clear").show();
        });
    });
    
    $container.find(".clear").click(function() {
        $container.find("input").val(0);
        $container.find(".title").hide();
        $container.find(".title-void").show();
        $container.find(".view").hide();
        $container.find(".clear").hide();
    })
    
    
})