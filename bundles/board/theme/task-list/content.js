mod.init(".MhpEuDh2NX", function() {
    
    var $container = $(this);
    
    // Перемотка 
    /*var $tabs = $container.find("> .status-list span");
    var $tabsData = $container.find("> table > tbody > tr > td");
    $tabs.each(function(n) {
        $(this).click(function() {
            var $data = $tabsData.eq(n);
            var offset = $data.position().left + $container.scrollLeft();
            $container.animate({
                scrollLeft: offset
            }, 500);
        })
    }); */
    
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
    
    // Скролл колесиком
    $(document).on("mousewheel", function(event) {
        var d = event.originalEvent.wheelDelta;
        $container.scrollLeft($container.scrollLeft() + d);
    })
    
    // Растягивание списка задач по горизонтали
    $container.find(".list-wrapper").each(function() {
        var $e = $(this);
        $e.width(120*2 + 20);
        /*setInterval(function() {
            var h1 = $e.get(0).scrollHeight;
            var h2 = $e.outerHeight();
            if(h1 > h2) {
                $e.width($e.width() + 50);
            }
        }, 100);*/
        
        //$e.width(120 * 3 + 10 * 2 + 20 * 2)
    });
    
});