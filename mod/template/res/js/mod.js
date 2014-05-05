$("<style>.mod-msg-container{top:20px;right:20px;position:fixed;z-index:100001000;}</style>").appendTo("head");
$("<style>.mod-msg{width:300px;background:black;color:white;padding:10px;margin-bottom:2px;border-radius:5px;}</style>").appendTo("head");
$("<style>.mod-msg-error{background:red;}</style>").appendTo("head");

mod = {};

/**
 * Выводит на экран высплывающее сообщение
 * Если второй параметр = true, сообщение - ошибка
 **/
mod.msg = function(text,error) {

    if(!mod.msg.__container) {
        mod.msg.__container = $("<div class='mod-msg-container' />").prependTo("body");
    }
    var msg = $("<div>")
		.addClass("mod-msg")
		.html(text+"");
		
    error && msg.addClass("mod-msg-error");
    msg.css("opacity",0);
    msg.appendTo(mod.msg.__container);
    
    msg.animate({opacity:1},500)
		.animate({opacity:1},2000)
		.animate({opacity:0},"slow")
		.hide("slow");
}

mod.handlers = {}

mod.on = function(name,handler) {
    if(!mod.handlers[name]) {
        mod.handlers[name] = [];
    }
    mod.handlers[name].push(handler);
}

/**
 * Вызывает событие name
 **/
mod.fire = function(name,params) {
    var handlers = mod.handlers[name];
    if(handlers) {
        for(var j in handlers) {
            handlers[j](params);
        }
    }
}

mod.uniqueCalls = {};


/**
 * Отправляет команду на сервер
 **/
mod.call = function(params,fn,conf) {

    if (!window.JSON) {
        return;
    }
    
    if(!conf) {
        conf = {}
    }
    
    var fdata = new FormData();
    fdata.append("data", JSON.stringify(params));   
    
    if(conf.files) {

        if(conf.files.constructor === Object) {

            for(var i in conf.files) {
                fdata.append(i, conf.files[i]);
            }

        } else {
            $(conf.files).find("input[type=file]").each(function() {
                fdata.append(this.name, this.files[0]);
            });
        }
    }
    
    // Если зазад уникальный id запроса, удаляем предыдущие запросы с таким id
    if(conf.unique) {
        var xhr = this.uniqueCalls[conf.unique];
        if(xhr) {
            xhr.abort();
        }
	}
    
    var xhr = $.ajax({
        url: "/mod_json/?cmd=" + params.cmd, // Добавляем команду к get-запросу (для логов)
        data: fdata,
        contentType: false,
        processData: false,        
        type:"POST",
        success:function(d){
            mod.handleCmd(true,d,fn);
        },
        error:function(r) {
            if(r.readyState!=0) {
                mod.handleCmd(false,r.responseText);
            }
        }
    });
    
    if(conf.unique) {
        this.uniqueCalls[conf.unique] = xhr;
    }
    
},

mod.parseCmd = function(str) {

    try{
        eval("var data="+str);
    } catch(ex) {
        return {
            success:false,
            text:str
        };
    }
    
    // Выводим сообщения
    for(var i=0;i<data.messages.length;i++) {
        var msg = data.messages[i];
        mod.msg(msg.text,msg.error);
    }      
    
    // Обрабатываем события
    for(var i=0;i<data.events.length;i++) {
        var event = data.events[i];
        mod.fire(event.name,event.params);
    }
    
    return {
        success:data.completed,
        data:data.data,
        meta:data.meta
    }
}

mod.handleCmd = function(success,response,fn) {

    // Если сам запрос к серверу не увенчался успехом
    if(!success) {
        mod.msg(response,1);
        return;
    }

    // Пробуем разобрать ответ от сервера
    var ret = mod.parseCmd(response);

    // При ошибке разбора показываем уведомление
    if(!ret.success) {
        mod.msg(ret.text,1);
        return;
    }

    if(fn)
        fn(ret.data);

}
