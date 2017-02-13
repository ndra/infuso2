if(!window.ndra) {
    window.ndra = {};
}

window.ndra.indyScroll = function(params) {
    
    // Параметры окна
    
    windowParams = {
        offsetTop: params.offsetTop || 0,
        scroll: 0
    };
    
    // Инициалиация
    
    $blocks = $(params.blocks);
    var $container = $(params.container);
    $blocks.each(function() {
        var $block = $(this);
        $block.css({
            position: "relative",
        })
        $wrapper = $block.children();
        $wrapper.css({
            position: "fixed",
        }).data("top", 0);
    });
    
    // Реакция на скролл
    
    var lastScroll = 0;
    $(window).scroll(function(event) {
        var scroll = $(window).scrollTop();
        var delta = scroll - lastScroll;
        lastScroll = scroll;
        windowParams.scroll = scroll;
        updateScroll(delta);
    });
    
    var fixPosition = function($block, $wrapper) {
    
       /* var $log = $wrapper.data("log");
        if(!$log) {
            $log = $("<div>")
                .css({
                    position: "absolute",
                    bottom: 0,
                    left: 0
                }).appendTo($wrapper)
                .html(Math.random());
            $wrapper.data("log", $log);
        }
        
        $log.html("");  */
        var log = function(html) {
            //$log.html($log.html() + html + "<br>");
        }
        
        var top = $wrapper.data("top") ;
        var bottom = top + $wrapper.outerHeight() - windowParams.height;
        var bounds = false;

        // Шапка отодвигает колонку вниз
        var containerTop = $container.offset().top - windowParams.scroll;
        if(containerTop > windowParams.offsetTop) {
            top = containerTop;
            bounds = true;
            log("header bounds");
        }
        

        
        if(!bounds) {
                
            // Если оба конца ленты выходят за край экрана, она может свободно прокручиваться
            // Если только один конец вылез, прибиваем ленту в ту сторону, где вылез
            if(top <= windowParams.offsetTop || bottom >= 0) {
                if(top > windowParams.offsetTop) {
                    top = windowParams.offsetTop;
                    log("sticked top");
                }
                if(bottom <= 0) {
                    top -= bottom;
                    log("sticked bottom");
                }
                
            }
            
            // Если у нас полчилось так что есть свободное пространство,
            // Прибиваем к верху
            if(top >= windowParams.offsetTop && bottom <= 0) {
                top = windowParams.offsetTop;
                log("free space sticked top");
            }
        
        }
        
        // Подвал отодвигает колонку вверх
        var a = $container.offset().top + $container.height() - windowParams.scroll - windowParams.height;
        var b = top + $block.outerHeight() - windowParams.height;
        var d = a - b;   
             
        if(a <= 0 && d < 0) {         
            top += d;
            log("footer bound");
        }

        
        $wrapper.data("top", top);
        
        var bottom = top + $wrapper.outerHeight() - windowParams.height;
        if(bottom == 0) {             
            $wrapper.css({
                position: "fixed",
                top: "auto",
                bottom: 0
            });
        } else {
        
            $wrapper.css({
                position: "fixed",
                top: $wrapper.data("top"),
                bottom: "auto"
            });
        }
        
    }
    
    // Обновляет скролл (передвигает блоки)
    var updateScroll = function(delta) {
        $blocks.each(function() {
            var $block = $(this);
            $wrapper = $block.children();
            $wrapper.data("top", $wrapper.data("top") - delta)
            fixPosition($block, $wrapper);
        });
    };
    
    // Обновляет размеры контейнеров
    // Вызывает обновление скролла
    var handleResize = function() {
        $blocks.each(function() {
            var $block = $(this);
            $wrapper = $block.children();
            $block.height($wrapper.outerHeight());     
            $wrapper.width($block.width());
        });
        windowParams.height = $(window).height();
        windowParams.containerTop = $container.offset().top;
        updateScroll(0);
    }
    
    handleResize();
    $(window).resize(handleResize);
    setInterval(handleResize, 1000);
    
}