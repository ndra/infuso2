mod.init(".lonjnbmi8k", function() {

    var container = $(this);
    var index = container.attr("data:index");

    $(this).find(".create-meta").click(function() {
        mod.call({
            cmd:"infuso/cms/reflex/controller/meta/create",
            index: index
        }, function() {
            container.trigger("reflex/updateMeta");
        });
    });
    
    
    var form = container.find(".meta-form");
    
    if(form.length) {

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
                cmd:"infuso/cms/reflex/controller/meta/save",
                index:form.attr("infuso:id"),
                data:formData
            });
            
        }
    
        form.submit(function(e) {
            // Предотвращаем отправку формы
            e.preventDefault();
            submit();
        });
        
        form.find(".remove").click(function() {
            mod.call({
                cmd:"infuso/cms/reflex/controller/meta/remove",
                index: index
            }, function() {
                container.trigger("reflex/updateMeta");
            });
        });
        
        container.mod("on", "keydown", function(e) {
            if(e.keyCode == 83 && e.ctrlKey) {
                e.preventDefault();
                submit();
            }
        });
        
    }
    
});