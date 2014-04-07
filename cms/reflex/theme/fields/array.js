$(function() {

    $(".vehszhivmz").mod().init(function() {
    
        var container = $(this).find(".items");
        container.html("");
        
        var data = {
            a:12121,
            b:"ололо!",
            c: "вывыв",
            ddd: "пыщ"
        };
        
        var renderData = function() {
        
            container.html("");
        
            for(var i in data) {
                var row = $("<div>");
                row.html(i+": "+data[i]);
                row.appendTo(container);
            }
        
        }
        
        $(this).find(".button-add").click(function(){
            var key = prompt("Введите ключ");
            var val = prompt("Введите знчение");
            data[key] = val;
            renderData();
        });
        
        $(this).find(".button-delete").click(function(){
            mod.msg("delete");
        });
        
    });

});