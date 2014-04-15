$(function() {

    $(".mm4tqxw2gk").each(function() {
    
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
                cmd:"infuso/cms/reflex/controller/createItem",
                constructorId:form.attr("infuso:constructor"),
                data:formData
            },function(url) {
                if(url) {
                    window.location.href = url;
                }
            });
            
        }
    
        form.submit(function(e) {
            // Предотвращаем отправку формы
            e.preventDefault();
            submit();
        });    
    
    });

})