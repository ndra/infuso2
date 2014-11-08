mod.init(".xaayzmpe0W", function() {
    
    var $container = $(this);
    var $input = $container.find("input[type='text']");
    var $hidden = $container.find("input[type='hidden']");
    var $list = $container.find(".list");
    
    var touched = false;
    
    // Загружает список элементов
    var load = function() {
        
        var call = JSON.parse($container.attr("data:call"));
        call.query = touched ? $input.val() : "";
        
        mod.call(call, function(ret) {
            $list.html("");
            for(var i in ret.items) {
                $("<div>")
                    .addClass("item list-item")
                    .data("id", ret.items[i].id)
                    .attr("data:id", ret.items[i].id)
                    .text(ret.items[i].title)
                    .click(function() {
                        collapse();
                    }).appendTo($list);
            }
            $list.list();
        });
    }
    
    $input.keydown(function(event) {
        switch(event.keyCode) {
            case 40:
                expand();
                $list.list("next");
                break;
            case 38:
                expand();
                $list.list("prev");
                break;
            case 13:
            case 27:
                if($list.is(":visible")) {
                    collapse();
                    event.preventDefault();
                }
                break;
        }
        
    });
    
    var selectFirst = function() {
        
        if($input.val()) {
            var $item = $list.children().first();
        } else {
            var $item = $("none");
        }
        var id = $item.data("id");
        var name = $item.text();
        $hidden.val(id);
        $input.val(name);
        touched = false;
    }
    
    // Разворачивает список
    var expand = function() {
        if($list.is(":visible")) {
            return;
        }
        $list.html("").show();
        load();
    }
    
    // Сворачивает список
    var collapse = function() {
        if(!$list.is(":visible")) {
            return;
        }
        $list.hide();
    }
    
    $input.blur(function() {
        if(touched) {
            selectFirst();
        }
        collapse();
    });
    $input.focus(expand);
    
    $input.on("input", function() {
        touched = true;
        load();
    });
    
    $list.on("list/select", function(event) {
        if(!event.selection.length) {
            return;
        }
        var $item = $list.find(".list-item.selected");
        var id = $item.data("id");
        var name = $item.text();
        $hidden.val(id);
        $input.val(name);
        touched = false;
    });
        
});