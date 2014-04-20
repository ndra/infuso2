$(function() {

    $(".x0f1k9gbr5c .go").click(function() {
        fetchClass();
    });

    var classList = [];
    $(".x0f1k9gbr5c .class").each(function() {
        classList.push($(this).text());
    });
    
    var fromId = null;
    var className = null;
    
    var log = function(txt) {
        mod.msg(txt);
    }
    
    var handleStep = function(data) {
    
        if(!data) {
            stepFailed();
            return;
        }        
        
        if(data.log) {
            log(data.log)
        }
        
        if(data.action == "nextClass") {
            fetchClass();
            return;
        }
        
        if(data.action == "nextId") {
            fromId = data.nextId;
            step();
            return;
        }
    
    }
    
    var step = function() {
        mod.call({
            cmd:"infuso/cms/reflex/controller/sync/syncStep",
            className: className,
            fromId: fromId
        },handleStep)
    }
    
    var done = function() {
    }
    
    var fetchClass = function() {
        className = classList.shift();
        if(!className) {
            done();
        } else {
            fromId = 0;
            step();
        }
    }

});