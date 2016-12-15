if(!window.mod) {

    $("<style>.mod-msg-container{top:20px;right:20px;position:fixed;z-index:100001000;}</style>").appendTo("head");
    $("<style>.mod-msg{width:300px;background:black;color:white;padding:10px;margin-bottom:2px;border-radius:5px;}</style>").appendTo("head");
    $("<style>.mod-msg-error{background:red;}</style>").appendTo("head");
    
    mod = function($e) {
    
    	return new function() {
    		this.init = function(fn, params) {
    			mod.init($e, fn, params);
    			return this;
			};
			this.on = function(name, handler) {
				mod.on(name, handler, $e);
			};
			
			this.formData = function() {
                $e = $($e);
			    var data = {};
		        var temp = $e.serializeArray();
		        for(var i in temp) {
		            data[temp[i].name] = temp[i].value;
		        }		        
		        $e.find("input[type='checkbox']").each(function() {
		            var val = !!$(this).prop("checked");
		            data[$(this).attr("name")] = val;
		        });		        
		        return data;
			}
		};
	};
    
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
    
    mod.requests = {};
    
    /**
     * Выполняет ассинхронный запрос к серверу
     * Запрос добавляется в буффер, который отправляется на сервер раз в 50мс
     * Таким образом запросы, сделанные одновременно, отправляются на сервер пачкой
     **/
    mod.call = function(params, onSuccess, conf) {
    
    	if(!conf) {
    	    conf = {};
    	}
        
        // Генерируем уникальный id для запроса
        conf.id = mod.id();
        
        // Отменяем запрос с таким же id
        if(conf.unique) {    
            for(var requestId in mod.requests) {
                if(mod.requests[requestId].conf.unique == conf.unique) {
                    mod.abort(mod.requests[requestId].conf.id);
                }
            }
        }
    
        mod.requests[conf.id] = {
            params: params,
            onSuccess: onSuccess,
            conf: conf
        };
    
    };
    
    /**
     * Отменяет запрос к серверу
     **/
    mod.abort = function(requestId) { 
        
        // Находим запрос по id
        var request = mod.requests[requestId];
        if(!request) {
            return;
        }        
        
        request.status = "cancelled";
        
        mod.abortAjaxForCancelledRequests();
    
    }
    
    mod.id = function() {       
        var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';     
        var length = 32;
        var result = '';
        for (var i = length; i > 0; --i) {
            result += chars[Math.floor(Math.random() * chars.length)];
        }
        return result;
    }
    
    /**
     * Отправляет пачку команд на сервер
     **/
    mod.send = function() {
        
        var requestsToSend = {};
        
        // Признак того, что есть запросы котоыре нужно отправить
        var needSend = false;
        
        // Сюда добавим файлы
        var fdata = new FormData();
        
        var ajaxId = mod.id();
        
        for(var requestId in mod.requests) {
        
            var request = mod.requests[requestId];             
                    
            if(!request.sent) {
        
                requestsToSend[requestId] = request.params; 
                needSend = true;           
                
                // Добавляем в fdata файлы из запросов
                // через префикс - id запроса
        		var files = request.conf.files;
        		if(files) {
        	        if(files.constructor === Object || files.constructor === FileList) {
        	            for(var ii in files) {
        	                fdata.append(requestId + "/" + ii, files[ii]);
        	            }
        	        } else {
        	            $(files).find("input[type=file]").each(function() {
        	                fdata.append(requestId + "/" + this.name, this.files[0]);
        	            });
        	        }
            	}
                
                request.ajaxId = ajaxId;
                request.sent = true;            
            }
        }     
        
        if(needSend) {    
    
            fdata.append("data", JSON.stringify({
                requests: requestsToSend
            }));
            
            // Строим урл запроса
            var urlId = [];
            for(var i in requestsToSend) {
                urlId.push((String)(requestsToSend[i].cmd).replace(/[^a-zA-Z0-9\/_]/g, ""));
            }
            urlId = urlId.join(",");
            
            var xhr = $.ajax({
                url: "/mod_json/?cmd=" + urlId,
                async: true,
                data: fdata,
                contentType: false,
                processData: false,        
                type: "POST",
                success: function(data) {
                    mod.handleCmd(data, ajaxId);
                }, error:function(r) {
                    if(r.status != 0) {
                        console.log(r);
                        mod.msg("Request failed " + r.responseText, true);
                        mod.removeCompletedRequests(ajaxId);                    
                    }
                }
            });
            
            for(var id in requestsToSend) {
                mod.requests[id].xhr = xhr;
            }
        
        }
        
    };
    
    setInterval(mod.send, 50);
    
    /**
     * Удаляет обработанные запросы из списка mod.requests
     **/
    mod.removeCompletedRequests = function(ajaxId) {            
        for(var requestId in mod.requests) {
            if(mod.requests[requestId].ajaxId == ajaxId) {
                delete mod.requests[requestId];
            }
        }
    }
    
    /**
     * Отменяет уже отправленные запросы на сервер
     * Запрос отменяется, если все запросы в нем (:) отменены
     * В противном случае, не трогаем запрос, но его колбэк не выполнится
     * и сообщения не будут выведены
     **/
    mod.abortAjaxForCancelledRequests = function() {   
    
        var xhrToRemove = {};
    
        // id ajax в которых есть хоть один отмененный запрос
        for(var requestId in mod.requests) {
            var request = mod.requests[requestId];
            if(request.xhr) {
                if(request.status == "cancelled") { 
                    xhrToRemove[request.ajaxId] = true;
                }
            }
        }         
        
        // Если в группе запросов есть хотя бы один не отмененный, мы не можем отменить весь запрос
        for(var requestId in mod.requests) {            
            var request = mod.requests[requestId];
            if(request.xhr) { 
                if(request.status != "cancelled") {
                    delete xhrToRemove[request.ajaxId];  
                }
            }
        }
       
        for(var requestId in mod.requests) {
            var request = mod.requests[requestId];
            if(xhrToRemove[request.ajaxId]) {
                request.xhr.abort();
                delete mod.requests[requestId];
            }
        }        
        
    }
    
    mod.handleCmd = function(response, ajaxId) {
    
        // Пробуем разобрать ответ от сервера
        try {
            eval("var data = " + response);
        } catch(ex) {
            mod.msg("Failed parse JSON: " + response, 1);
            mod.removeCompletedRequests(ajaxId);
            return;
        }         
      
        for(var requestId in data) {
        
            var result = data[requestId];
            var request = mod.requests[requestId];
            
            if(request.status != "cancelled") {
    
                // При ошибке показываем уведомление
                if(result.success) {
                
                    if(request.onSuccess) {
                        request.onSuccess(result.data);
                    }
                    
                    // Обрабатываем события
                    for(var i = 0; i < data[requestId].events.length; i++) {
                        var event = data[requestId].events[i];
                        mod.fire(event.name, event.params);
                    } 
                
                }
                
                // Выводим сообщения
                for(var i = 0; i < data[requestId].messages.length; i++) {
                    var msg = data[requestId].messages[i];
                    mod.msg(msg.text, msg.error);
                }      
                
            }
        
        }
        
        mod.removeCompletedRequests(ajaxId);
    
    }
    
    mod.init = function(selector, fn, params) {
	
		if(!params) {
			params = {};
		}
		
		if(!params.key) {
			params.key = "";
		}
	      
    	$(function() {            
	        $(selector).each(function() {
		        if(!$(this).data("hrbCtS8MoMw61V" + params.key)) {
		            fn.apply(this);
		            $(this).data("hrbCtS8MoMw61V" + params.key, true);
		        }
	        });         
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
        $e.data("PmhHipW-last", mod.getMonitorProp($e, $e.data("PmhHipWLXkGk82RcU")));
    }
    
    mod.getMonitorProp = function($e, propName) {
        switch(propName) {
            case "width":
                return $e.outerWidth();
            default:
                return $e.prop(propName);
        }
    }
    
    setInterval(function() {
        $(".PmhHipWLXkGk82RcU").each(function() {
            var $e = $(this);   
            var propName = $e.data("PmhHipWLXkGk82RcU");
            var val = mod.getMonitorProp($e, propName);
                                                                
            if(val != $e.data("PmhHipW-last")) {
                if($e.data("PmhHipW-last") !== undefined) {
                    $e.trigger("mod/monitor");
                }
                $e.data("PmhHipW-last", val);
            }
        });
    }, 300);
    
    /**
     * Вызывает отложенную функцию
     **/
    mod.delay = function(fn, delay) {
    
        if(fn.timer) {
            return;
        }
        
        if(!delay) {
            delay = 1000;
        }
        
        fn.timer = true;
        
        setTimeout(function() {
            fn();
            fn.timer = null;
        }, delay);
    
    }

}