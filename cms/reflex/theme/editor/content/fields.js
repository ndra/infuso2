$(function() {

    $(".svfo38b38d").each(function() {
    
        var form = $(this);
    
        //  Сохраняет данные формы
        var submit = function() {
        
            // Собираем данные формы
            var serialized = form.serializeArray();
            var formData = {};
            for(var i in serialized) {
                formData[serialized[i].name] = serialized[i].value;
            }
            
            // Отправляем на сервер команду сохранения
            mod.call({
                cmd:"infuso/cms/reflex/controller/save",
                index:form.attr("infuso:id"),
                data:formData
            });
            
        }
    
        $(this).submit(function(e) {
            // Предотвращаем отправку формы
            e.preventDefault();
            submit();
        });
        
        $(form).mod("on", "keydown", function(e) {
            if(e.keyCode == 83 && e.ctrlKey) {
                e.preventDefault();
                submit();
            }
        });
    
    });

})