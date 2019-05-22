mod.init(".K1ci1AAFuh", function() {
   
    var $container = $(this);
    $container.list();
    
    var $input = $container.find("input");
    var $dropdown = $container.children(".dropdown");
    var $itemsTable = $container.find(".items-table");
    var $valueTable = $container.find(".value-table");
    
    var expand = function() {
        $dropdown.show();
    }
    
    var collapse = function() {
        $dropdown.hide();
    }
    
    $container.find(".input-like").click(expand);
    
    // Показывает выбранный элемент 
    // Копирует html элемента из списка а тайтл
    var showSelected = function() {
        var id = $input.val();
        $itemsTable.find(".list-item").each(function() {
            if($(this).attr("data:id") == id) {
                $valueTable.html($(this).html());
            }
        });
    };
    
    $itemsTable.click(function(event) {
        var id = $(event.target).parents(".list-item").attr("data:id");
        if(id) {
            $input.val(id);
            collapse();
        }
    });
    
    showSelected();
    
    mod.monitor($input, "value");
    $input.on("mod/monitor", function() {
        showSelected();    
        $input.trigger("change");
    });
    
    $(document).click(function(event) {
        if(!$(event.target).parents().is($container)) {
            collapse();
        }
    });
    
});