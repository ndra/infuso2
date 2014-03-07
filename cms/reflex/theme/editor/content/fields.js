$(function() {

    $(".svfo38b38d").each(function() {
    
        $(this).submit(function(e) {
        
            // Предотвращаем отправку формы
            e.preventDefault();
            
            // Собираем данные формы
            var serialized = $(this).serializeArray();
            var formData = {};
            for(var i in serialized) {
                formData[serialized[i].name] = serialized[i].value;
            }
            
            // Отправляем на сервер команду сохранения
            mod.cmd({
                cmd:"infuso/cms/reflex/controller/save",
                id:$(this).attr("infuso:id"),
                formData:formData
            });
        });
    
    });

})