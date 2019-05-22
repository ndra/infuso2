jQuery.fn.formatTable = function() {

	$table = $(this); 
        
    // Находим TBODY 
    var $tbody = $table.find("tbody")
    
    // Определяем количество столбцов
    var n = $tbody.find("tr:first td").length;
    
    // Для каждого столбца...
    for(var i = 1; i <= n; i ++) {
    
        // Ширина столбца, будет определена далее
        var width = 0;
        
        // Все TD, образующие столбец
        var $col = $tbody.children("tr").children("td.format:nth-child(" + i + ")");
        
        // Для каждого TD из стоблца...
        $col.each(function() {
            
            // Оборачиваем содержимое ячейки в DIV
            // Если вызывается второй раз
            if(!$(this).data("A4wrCVJ4rz")) {
                var $div = $("<div>")
                    .css("display", "inline-block")
                    .css("white-space", "nowrap")
                    .css("text-align", "right")
                    .html($(this).html());
                $(this).html($div)
                    .css("text-align", "center")
                    .data("A4wrCVJ4rz", true);
            } else {
                var $div = $(this).children("div:first");
            }
            
            // Расчитываем максимальную ширину ячеек
            width = Math.max(width, $div[0].scrollWidth);
            
        });
        
        $col.find(">div").width(width);
    
    }

};
