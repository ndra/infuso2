mod.init(".MhpEuDh2NX", function() {
    
    var $container = $(this);
    
    var drag = false;
    var sx = 0;
    var sy = 0;
    var dx = 0;
    var dy = 0;
    
    $container.on("mousedown", function(event) {
        
        if($(event.target).parents().andSelf().filter(".task, input, .disable-pan").length) {
            return;
        }
        
        event.preventDefault();
        drag = true;
        sx = event.pageX;
        sy = event.pageY;
        dx = $container.scrollLeft();
        dy = $container.scrollTop();
    });
    
    mod.on("mousemove", function() {
        if(drag) {
            event.preventDefault();
            $container.scrollLeft(dx - event.pageX + sx);
            $container.scrollTop(dy - event.pageY + sy);
        }
    }, $container);
    
    mod.on("mouseup", function() {
        drag = false;
    }, $container);
    
    $container.on("scrollToElement", function() {
        mod.msg("scroll to element");
    });
    
});