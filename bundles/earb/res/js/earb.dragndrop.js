
/**
 * Конструктор драгндропа
 **/
earb.dragndrop = function($e) {

    $e = $($e); 
    $e.mousedown(function(event) {
    
        if(!earb.dragndrop.element) {
        
            event.preventDefault();
        
            // Перетаскиваемый элемент. Тот, на который кликнули и потащили
            earb.dragndrop.element = $e;           
            // Начальная позиция элемента
            earb.dragndrop.origin = {
                x: event.screenX,
                y: event.screenY
            };
        }
    });

};

earb.dragndrop.start = function() {
    earb.dragndrop.dragger = $("<div>")
        .css("position", "absolute")
        .css("left", earb.dragndrop.element.offset().left)
        .css("top", earb.dragndrop.element.offset().top)
        .css("width", earb.dragndrop.element.outerWidth())
        .css("height", earb.dragndrop.element.outerHeight())
        .css("border", "2px solid rgba(0,0,0,.3)")
        .css("box-sizing", "border-box")
        .css("pointer-events", "none")
        .appendTo("body");
} 

earb.dragndrop.handleMouseMove = function(event) {

    if(!earb.dragndrop.element) {
        return;
    }
    
    event.preventDefault();        
    if(!earb.dragndrop.dragger) {
        earb.dragndrop.start();
    }  
    
    // Вычисляем смещение с прошлого раза       
    var d = {
        x: event.screenX - earb.dragndrop.origin.x,
        y: event.screenY - earb.dragndrop.origin.y
    };          
    
    earb.dragndrop.dragger
        .css("margin-left", d.x)
        .css("margin-top", d.y);
}

earb.dragndrop.handleMouseUp = function(event) {

    if(!earb.dragndrop.element) {
        return;
    }
    
    var d = {
        x: event.screenX - earb.dragndrop.origin.x,
        y: event.screenY - earb.dragndrop.origin.y
    };  
    earb.dragndrop.element.triggerHandler({
        type: "mod/dragend",
        dx: d.x,
        dy: d.y
    });
    
    $(event.target).trigger({
        type: "mod/drop",
        dragElement: $(earb.dragndrop.element)
    });
    
    earb.dragndrop.element = null;
    
    if(earb.dragndrop.dragger) {
        earb.dragndrop.dragger.remove();
        earb.dragndrop.dragger = null;
    }
                       
}

$(window).mousemove(earb.dragndrop.handleMouseMove);
$(window).mouseup(earb.dragndrop.handleMouseUp);
