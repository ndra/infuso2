mod.init(".svfo38b38d", function() {
    
    var $form = $(this);

    //  Сохраняет данные формы
    var submit = function() {
    
        // Собираем данные формы
        var serialized = $form.serializeArray();
        var formData = {};
        for(var i in serialized) {
            formData[serialized[i].name] = serialized[i].value;
        }
        
        // Отправляем на сервер команду сохранения
        mod.call({
            cmd: "infuso/cms/reflex/controller/save",
            index: $form.attr("infuso:id"),
            data: formData
        });
        
    }
    
    //обработчки события сейва
    var saveHandler = function (event) {
        mod.fire("reflex/beforeSave");    
        event.preventDefault();
        submit();    
    }
    
    $form.submit(function(event) {
        // Предотвращаем отправку формы
        saveHandler(event);
    });
    
    mod.on("keydown", function(event) {
        if(event.keyCode == 83 && event.ctrlKey) {
            saveHandler(event);    
        }
    });

})