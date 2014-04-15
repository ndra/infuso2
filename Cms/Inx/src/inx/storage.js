// @link_with_parent

inx.storage = {

    buffer:{},

    set:function(key,val) {       
        inx.storage.buffer[key] = val;
        if(inx.storage.ready & !inx.storage.dumpPlanned) {
            setTimeout(function(){
                inx.storage.flush();
            },300);
            inx.storage.dumpPlanned = true;            
        }
    },
    
    flush:function() {
        for(var key in inx.storage.buffer) {
            var val = inx.storage.buffer[key];
            key = inx.storage.hash(key);
            try { Storage.put(key,inx.json.encode(val)); }
            catch(ex) { inx.msg("storage error",1); inx.msg(ex,1); }
        }
        inx.storage.dumpPlanned = false;        
        inx.storage.buffer = {};
    },
    
    get:function(key) {
        try {
            var ret = inx.storage.buffer[key];
            if(ret!==undefined) return ret;
            if(!inx.storage.ready) return null;
            key = inx.storage.hash(key);
            return inx.json.decode(Storage.get(key));
        } catch(ex) {
            inx.msg("inx.storage.get",1);
            inx.msg(ex,1);
        }
    },
    
    keys:function() {
        if(!inx.storage.ready) return [];
        inx.storage.flush();
        return Storage.getKeys();
    },
    
    onready:function(id,cmd) {
        id = inx(id).id();
        if(inx.storage.ready) {
            inx(id).cmd(cmd);
            return;
        }
        inx.storage.h.push({id:id,cmd:cmd});
    },
    
    h:[],
    
    private_init:function() {
        inx.storage.ready = true;    
        for(var i=0;i<inx.storage.h.length;i++)
            inx(inx.storage.h[i].id).cmd(inx.storage.h[i].cmd);
        inx.storage.flush();
    },
    
    hash:function(key) {
        key+="";
        var ret = "";
        for(var i=0;i<key.length;i++)
            ret+= "x"+key.charCodeAt(i);
        return key.replace(/\.|\:/g,"_");
    }
},

/**
 * (c) 2008, Ilya Kantor
 * 1.1
 * http://browserpersistence.ru - Последняя версия и документация
 * Разработка спонсирована компанией Интернет-Обновление
 * http://obnovlenie.ru
 *
 * Вы можете делать с этим кодом, что хотите, но оставьте эти строки
 * И, пожалуйста, сообщайте об ошибках и полезных дополнениях на http://browserpersistence.ru
 * 
 */


/**
 * Использование:
 *
 * Внутри document.body, или после onDOMContentLoaded (чтобы было body):
 *   Storage.init(function() { .. Каллбэк после успешной загрузки .. }
*/
Storage = {
    
    // Flash8 загружается последним и асинхронно, остальные - синхронно
    engines: ["WhatWG", "userData", "Flash8"],
    //"userData",
    
    swfUrl: inx.path("%res%/swf/storage.swf"),
        
    init: function(onready) {       
        for(var i=0; i<this.engines.length; i++) {                    
                    
            try {
                this[this.engines[i]](function() { Storage.active = true; onready && onready()})
                return;                       
            } catch(e) {
                // uncomment to see errors                
                //alert(this.engines[i]+':<'+e.message+'>\n')
                //inx.msg((this.engines[i]+':<'+e.message+'>\n'));
            }        
        }
        inx.msg("No storage found",1);
        //inx.msg(i);         
        
    }
    
}

    

Storage.WhatWG = function(onready) {
    
    var storage = globalStorage[location.hostname];
            
    Storage = {
    
        put: function(key, value) {
            storage[key] = value
        },
        
        get: function(key) {
            return String(storage[key])
        },
        
        remove: function(key) {
            delete storage[key]
        },    
        
        getKeys: function() {
            var list = []
            
            for(i in storage) list.push(i)
            
            return list
        },
        
        clear: function() {
            for(i in storage) {
                delete storage[i]
            }
        }     
    }
    
    onready()
}




Storage.userData = function(onready) {
    var namespace = "data"    

    if (!document.body.addBehavior) {            
        throw new Error("No addBehavior available")
    }
        
    var storage = document.getElementById('storageElement');
    if (!storage) {
        storage = document.createElement('span')
        document.body.appendChild(storage)
        storage.addBehavior("#default#userData");
        storage.load(namespace);
    } 
    
    Storage = {
        put: function(key, value) {
            storage.setAttribute(key, value)
            storage.save(namespace)
        },
        
        get: function(key) {
            return storage.getAttribute(key)
        },
        
        remove: function(key) {
            storage.removeAttribute(key)
            storage.save(namespace)
        },
        
        getKeys: function() {
            var list = []
            var attrs = storage.XMLDocument.documentElement.attributes
            
            for(var i=0; i<attrs.length; i++) {
                list.push(attrs[i].name)
            }
            
            return list
        },
        
        clear: function() {
            var attrs = storage.XMLDocument.documentElement.attributes
            
            for(var i=0; i<attrs.length; i++) {
                storage.removeAttribute(attrs[i].name)
            }
            storage.save(namespace)
        }
    }
    
    onready();
}


Storage.Flash8 = function(onready) { 
    
    var movie
        
    var swfId = "StorageMovie"
    while(document.getElementById(swfId)) swfId = '_'+swfId
    
    var swfUrl = Storage.swfUrl
    
    // first setup storage, make it ready to accept back async call
    Storage = {       
 
        put: function(key, value) {
            movie.put(key, value)        
        },
        
        get: function(key) {
            return movie.get(key)
        },
        
        remove: function(key) {
            movie.remove(key)
        },
        
        getKeys: function() {
            return movie.getkeys()  // lower case in flash to evade ExternalInterface bug         
        },
        
        clear: function() {
            movie.clear()
        },
        
        ready: function() {
            movie = document[swfId]
            onready();
        }
    }
    
    // now write flash into document
    
    var protocol = window.location.protocol == 'https' ? 'https' : 'http'

    var containerStyle = "width:0; height:0; position: absolute; z-index: 10000; top: -1000px; left: -1000px;"        

    var objectHTML = '<embed src="' + swfUrl + '" '
                              + ' bgcolor="#ffffff" width="0" height="0" '
                              + 'id="' + swfId + '" name="' + swfId + '" '
                              + 'swLiveConnect="true" '
                              + 'allowScriptAccess="sameDomain" '
                              + 'type="application/x-shockwave-flash" '
                              + 'pluginspage="' + protocol +'://www.macromedia.com/go/getflashplayer" '
                              + '></embed>'
                    
    var div = document.createElement("div");
    div.setAttribute("id", swfId + "Container");
    div.setAttribute("style", containerStyle);
    div.innerHTML = objectHTML;
    
    document.body.appendChild(div)
}

$(function() {
    Storage.init(inx.storage.private_init)
});
