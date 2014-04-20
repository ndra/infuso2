$(function() {

    var classList = [];
    $(".x0f1k9gbr5c .class").each(function() {
        classList.push($(this).text());
    });
    
    var fromId = null;
    var className = null;
    
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
        this.call({
            cmd:"reflex/sync/syncStep",
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
    },

});