$(function() {

    $(".vehszhivmz").mod().init(function() {
    
        var container = $(this).find(".items");
        container.html("");
        
        var data = {
            "a":12121,
            "b":"ололо!",
            "c": "вывыв",
            "ddd": "пыщ"
        };
        
        var renderData = function() {
        
            container.html("");
        
            for(var i in data) {
                var row = $("<div>")
                    .html(i+": "+data[i])
                    .addClass("list-item")
                    .attr("data:id", i)
                    .appendTo(container);
            }
            
            container.list();
        
        }
        
        renderData();
        
        $(this).find(".button-add").click(function(){
            var key = prompt("Введите ключ");
            var val = prompt("Введите знчение");
            data[key] = val;
            renderData();
        });
        
        $(this).find(".button-delete").click(function() {
            var newData = {};
            var sel = container.list("selection");
            for(var i in data) {
                if($.inArray(i,sel) == -1) {
                    newData[i] = data[i];
                }
            }
            data = newData;
            renderData();
        });
        
    });

});