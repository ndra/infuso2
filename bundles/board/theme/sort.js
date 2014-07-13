mod.init(".ogtvEmHlon", function() {
    
    var $container = $(this);
    var $items = $container.find(".item");
    var $drops = $container.find(".prev, .next, .here");
    
    var itemX = 0;
    var itemY = 0;
    
    var $dragItem;
    
    $items.on("dragstart", function(event) {
        itemX = event.originalEvent.pageX - $(this).offset().left;
        itemY = event.originalEvent.pageY - $(this).offset().top;
        $dragItem = $(this);
        /*setTimeout(function() {
            $dragItem.css("visibility", "hidden");
        },100); */
    });
    
    $container.on("dragenter", function() {
        //mod.msg("drag enter");
    });
    
    $container.on("dragover", function(event) {
        var x = event.originalEvent.pageX + $dragItem.outerWidth() / 2;
        var y = event.originalEvent.pageY + $dragItem.outerHeight() / 2;
        var $nearest = findNearest(x - itemX, y - itemY);
        
        $drops.css({
            outline: "none"
        })
        
        $nearest.css({
            outline: "2px solid blue"
        })
        /*if($nearest[0].isEqualNode($dragItem[0])) {
            return;
        } */

    });
    
    var findNearest = function(x,y) {
        //var dMin = null;
        $ret = $("none");
        $drops.each(function() {
            
            var x1 = $(this).offset().left;
            var y1 = $(this).offset().top;
            var x2 = x1 + $(this).outerWidth();
            var y2 = y1 + $(this).outerHeight();
            
            if(x > x1 && x < x2 && y > y1 && y < y2) {
                $ret =  $(this);
            }
        });
        
        return $ret;
    }
    
});