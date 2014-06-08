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
            call:{ 
                cmd: "infuso/cms/reflex/controller/field/linksAdd",
                editor: $container.attr("data:editor"),
                field: $container.attr("data:field"),
            }
        }).on("links/select", function(event) {
            var val = $input.val();
            val += " " + event.itemID;
            $input.val(val);
            load();
        });
    });
    
    $container.on("links/remove", function(event) {
        var val = $input.val().split(" ");
        var val2 = [];
        for(var i in val) {
            var id = val[i] * 1;
            if(id != event.itemID) {
                val2.push(id);
            }
        }
        $input.val(val2.join(" "));
        load();
    });
    
    
});