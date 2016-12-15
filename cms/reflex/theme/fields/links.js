mod.init(".QWQ2cWdbx", function() {
    
    var $container =  $(this);
    var $input = $(this).find("input");
    
    var load = function() {
        mod.call({ 
            cmd: "infuso/cms/reflex/controller/field/linksContent",
            editor: $container.attr("data:editor"),
            field: $container.attr("data:field"),
            value: $input.val()
        }, function(html) {
            $container.find(".ajax").html(html);
        })
    }

    $container.find(".add").click(function() {
        $.window({
            width: 600,
            height: 400,
            call:{ 
                cmd: "infuso/cms/reflex/controller/field/linksAdd",
                editor: $container.attr("data:editor"),
                field: $container.attr("data:field"),
            }
        }).on("links/select", function(event) {
            var val = $input.val();
            val += " " + event.itemID;
            $input.val(val);
            $input.trigger("change");
            load();
        });
    });
    
    var update = function() {
        var val = [];
        $container.find(".item").each(function() {
            val.push($(this).attr("data:id"));
        });
        $input.val(val.join(" "));
        $input.trigger("change");
        
        // Черная магия
        // Если val == 0, значит див с элементами пуст
        // Это случится если мы удалим все элементы
        // В этом случае нужно показать текст о том что список пуст
        // Вот мы и дергаем функцию load()
        if(val.length == 0) {
            load();
        }
        
    }
    
    $container.on("links/remove", update);
    $container.on("links/sort", update);
    
});