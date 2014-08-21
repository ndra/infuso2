var form = function(selector, formx, scenario) {

    $(selector).submit(function(e) {

        var form = $(this);
        e.preventDefault();
        var data = $(this).serializeArray();
        //собираем с полей типа файла данные
        $(selector).find("[type='file']").each(function(){
            var obj = {};
            obj.name = $(this).attr("name");
            obj.value = $(this).val();
            data.push(obj);
        });
        var ret = {};
        for(var i in data) {
            ret[data[i].name] = data[i].value;
        }
        var data = ret;
        delete data.cmd;

        mod.call({
            cmd: "infuso/cms/form/controller/validate",
            data: data,
            form: formx,
            scenario: scenario
        },function(d) {

            form.find(".lbdmv238az").hide("fast");
            form.find("input.error, textarea.error").removeClass("error");

            // Если форма валидна, отправляем ее
            if(d.valid) {
               
               // При срабатывании события afterValidation достаем событие 
               var event;
               $(selector).on("afterValidation.eventSaver", function(e){
                   event = e;
               });
               
               //запускаем событие afterValidation
               $(selector).trigger("afterValidation", data);               
               
               //Если событие неыбло прервано то сабмитим форму
               if(!event.isDefaultPrevented()){
                   form.unbind("submit");
                   form.submit();        
               } 
               
               $(selector).off("afterValidation.eventSaver");     
                
            // Если форма не валидна, показываем сообщение об ошибке
            } else {
            
                for(var i in d.errors) {
                
                    var error = d.errors[i];                    

                    var field = form.find("[name=" + error.name + "]");
                    var msg = form.find(".error-" + error.name);
    
                    if(!field.length) {
                        mod.msg("Element <b>[name=" + error.name + "]</b> not found inside <b>" + selector + "</b>",1);
                    }
    
                    if(!msg.length) {
                        mod.msg("Element <b>.error-" + error.name + "</b> not found inside <b>" + selector + "</b>",1);
                    }
    
                    // Фокусируемся на элементе с ошибкой если он видимый
                    // Если элемент скрыт, добавляем временный инпут в сообщение об ошибке
                    // Это заставит браузер перемотать страницу и показать сообщение об ошибке
                    if(field.filter(":visible").length) {
                        field.focus();
                    } else {
                        $("<input>").appendTo(msg).focus().remove();
                    }
    
                    msg.html(error.text).hide().addClass("lbdmv238az").show("fast", function(){
                        //запускаем событие fieldError
                        $(selector).trigger("fieldError", data);    
                    });
                    
                    field.addClass("error");
                }
            }
        });
    });

}
