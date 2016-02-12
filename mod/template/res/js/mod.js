if(!window.mod) {

    $("<style>.mod-msg-container{top:20px;right:20px;position:fixed;z-index:100001000;}</style>").appendTo("head");
    $("<style>.mod-msg{width:300px;background:black;color:white;padding:10px;margin-bottom:2px;border-radius:5px;}</style>").appendTo("head");
    $("<style>.mod-msg-error{background:red;}</style>").appendTo("head");
    
    mod = {};
    
	mod.messages = [];
    
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
    		
		mod.messages.push({
		    text: text,
		    error: error
		});
    		
        error && msg.addClass("mod-msg-error");
        msg.css("opacity",0);
        msg.appendTo(mod.msg.__container);
        
        msg.animate({opacity:1},500)
    		.animate({opacity:1},2000)
    		.animate({opacity:0},"slow")
    		.hide("slow");
    }
    
    mod.handlers = {}
    
    /**
     * Подписывает на событие
     * name - имя события
     * handler - функция-обработчик
     * element - элемент, в контексте которого будет выполнятся обработчик   
     **/ 
    mod.on = function(name, handler, element) {
    
        if(!element) {
            element = $(document);
        }
    
        if(!mod.handlers[name]) {
            mod.handlers[name] = [];
        }
        
        mod.handlers[name].push({
            fn: handler,
            element: element
        });
    }
    
    /**
     * Вызывает событие name
     **/
    mod.fire = function(name,params) {
    
        var handlers = mod.handlers[name];
        if(handlers) {
        
            var handlers2 = [];
            for(var i in handlers) {
                var element = $(handlers[i].element).get(0);             
                if(jQuery.contains(document, element) || document === element ) {
                    handlers2.push(handlers[i])
                } 
            }
            
            handlers = handlers2;
            mod.handlers[name] = handlers2;
       
            for(var i in handlers) {
                handlers[i].fn(params);
            }
        }
    }
    
    mod.requests = [];
    
    mod.call = function(params, onSuccess, conf) {
    
    	if(!conf) {
    	    conf = {};
    	}
    
        mod.requests.push({
            params: params,
            onSuccess: onSuccess,
            conf: conf
        })
    
    };
    
    /**
     * Отправляет команду на сервер
     **/
    mod.send = function() {
    
        if(!mod.requests.length) {
            return;
        }
    
        if (!window.JSON) {
            return;
        }    
        
        var requests = [];
        var onSuccess = [];
    
        
        var fdata = new FormData();
        
        for(var i in mod.requests) {
            requests[i] = mod.requests[i].params;
            onSuccess[i] = mod.requests[i].onSuccess;
            
    		var files = mod.requests[i].conf.files;
    		if(files) {
    	        if(files.constructor === Object) {
    	            for(var ii in files) {
    	                fdata.append(i + "/" + ii, files[ii]);
    	            }
    	        } else {
    	            $(files).find("input[type=file]").each(function() {
    	                fdata.append(i + "/" + this.name, this.files[0]);
    	            });
    	        }
        	}
        }
    
        fdata.append("data", JSON.stringify({
            requests: requests
        }));
        
        mod.requests = [];
        
        var urlId = [];
        for(var i in requests) {
            urlId.push(requests[i].cmd);
        }
        urlId = urlId.join(",");
        
        var xhr = $.ajax({
            url: "/mod_json/?cmd=" + urlId,
            async: true,
            data: fdata,
            contentType: false,
            processData: false,        
            type: "POST",
            success: function(d) {
                mod.handleCmd(d, onSuccess);
            },
            error:function(r) {
                if(r.readyState != 0) {
                    mod.handleCmd(false,r.responseText);
                }
            }
        });
        
    };
    
    setInterval(mod.send, 50);
    
    mod.handleCmd = function(response, onSuccess) {
    
        // Пробуем разобрать ответ от сервера
        try{
            eval("var data="+response);
        } catch(ex) {
            mod.msg("Failed parse JSON: " + response, 1);
        }
        
        // Выводим сообщения
        for(var i = 0; i < data.messages.length; i++) {
            var msg = data.messages[i];
            mod.msg(msg.text, msg.error);
        }      
        
        // Обрабатываем события
        for(var i = 0; i < data.events.length; i++) {
            var event = data.events[i];
            mod.fire(event.name, event.params);
        }
        
        for(var i in data.results) {
        
            var result = data.results[i];
    
            // При ошибке разбора показываем уведомление
            if(!result.success) {
                mod.msg(result.text,1);
                return;
            }
        
            if(onSuccess[i]) {                
                onSuccess[i](result.data);
            }
        
        }
    
    }
    
    mod.init = function(selector, fn) {   
        $(function() {
            $(selector).mod("init", fn);
        });   
    }       
    
    mod.init(document,function() {
        $(this).keydown(function(event) { 
            mod.fire("keydown", event);
        });
        $(this).mousemove(function(event) { 
            mod.fire("mousemove", event);
        });
        $(this).mouseup(function(event) { 
            mod.fire("mouseup", event);
        });
    });
    
    /**
     * Делает копию переданного объекта рекурсивно
     **/ 
    mod.deepCopy = function(obj) {
    
        if(obj instanceof Array) {
            var clone = [];
        } else {
            var clone = {};
        }
        
        for(var i in obj) {
            if(typeof(obj[i])=="object") { 
                // Простые объекты (массивы) мы клонируем
                if(obj[i] && (obj[i].constructor==({}).constructor || obj[i].constructor==([]).constructor )) {        
                    clone[i] = inx.deepCopy(obj[i]);     
                }            
                //  Объекты с прототипами (Объекты jquery, inx :) и т.п. - оставляем как есть)       
                else {
                    clone[i] = obj[i];
                } 
            } else {
                clone[i] = obj[i];
            }
        }
        return clone;
    
    }
    
    mod.monitor = function($e, propName) {
        $e.addClass("PmhHipWLXkGk82RcU");
        $e.data("PmhHipWLXkGk82RcU", propName);
    }
    
    mod.monitorReset = function($e, propName) {
        $e.data("PmhHipW-last", $e.prop($e.data("PmhHipWLXkGk82RcU")));
    }
    
    setInterval(function() {
        $(".PmhHipWLXkGk82RcU").each(function() {
            var $e = $(this);
            if($e.prop($e.data("PmhHipWLXkGk82RcU")) != $e.data("PmhHipW-last")) {
                if($e.data("PmhHipW-last") !== undefined) {
                    $e.trigger("mod/monitor");
                }
                $e.data("PmhHipW-last", $e.prop($e.data("PmhHipWLXkGk82RcU")));
            }
        });
    }, 300);

}

