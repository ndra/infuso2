jQuery.fn.mod = function(param) {

	/**
	 * Возвращает данные формы в виде массива ключ => значение
	 * Данные чекбоксов собираются аналогично другим полям:
	 * Ключ - имя чекбокса
	 * Значение - 0 или 1 в зависимости от того выбран ли чекбокс
	 **/
    if(param === "formData") {
        var data = {};
        var temp = $(this).serializeArray();
        for(var i in temp) {
            data[temp[i].name] = temp[i].value;
        }
        
        $(this).find("input[type='checkbox']").each(function() {
            var val = !!$(this).prop("checked");
            data[$(this).attr("name")] = val;
        });
        
        return data;
    }
    
    if(param == "init") {
        if(!$(this).data("hrbCtS8MoMw61V")) {
            fn.apply(this);
            $(this).data("hrbCtS8MoMw61V", true);
        }
    };
}
