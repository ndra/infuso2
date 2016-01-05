mod.init(".GCADRNLmXZ", function() {
    
    var $container = $(this);
    
    $container.find(".submit").click(function() {
        
        var data = {
            options:[]
        };  
    
        // Собираем данные чекбоксов
        $container.find(":checkbox:checked").each(function(){
            data.options.push($(this).attr("name"));
        });
        
        // Собираем данные радиокнопок
        $container.find(":radio:checked").each(function(){
            data.options.push($(this).attr("value"));
        });
    
        data.pollId = $container.attr("data:id");
        data.cmd = "infuso/poll/controller/submit";
        mod.call(data,function(r) {
            $container.hide("fast");
            var $div = $("<div>").html(r).hide();
            $container.after($div);
            $div.show("fast");
        });
        
    });

});