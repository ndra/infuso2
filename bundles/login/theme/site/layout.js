$(function() {
    
    var $tooltip = null;
    
    var show = function(rects, text) {
        
        var regFirst = mod.deepCopy(rects[0]);
        var regLast = mod.deepCopy(rects[rects.length - 1]);
        
        regFirst.left += $(window).scrollLeft();
        regFirst.top += $(window).scrollTop();
        regFirst.right += $(window).scrollLeft();
        regFirst.bottom += $(window).scrollTop();
        
        regLast.left += $(window).scrollLeft();
        regLast.top += $(window).scrollTop();
        regLast.right += $(window).scrollLeft();
        regLast.bottom += $(window).scrollTop();
        
        var visibleRect = {
            left: $(window).scrollLeft(),
            top: $(window).scrollTop(),
            right: $(window).scrollLeft() + $(window).width(),
            bottom: $(window).scrollTop() + $(window).height()
        }
        
        if(!$tooltip) {
            $tooltip = $("<div>")
                .addClass("x-tooltip")
                .appendTo("body");
        }
        $tooltip.css({
            left: 0,
            top: 0
        }).html(text).stop(true).fadeIn("fast");
        
        // Размеры тултипа
        var width = $tooltip.outerWidth();
        var height = $tooltip.outerHeight();
        
        // Справа-снизу
        if(regLast.right + width < visibleRect.right && regLast.bottom + height < visibleRect.bottom) {
            $tooltip.css({
                left: regLast.right,
                top: regLast.bottom
            });
        
        // Вправо-вверх    
        } else if (regFirst.right + width < visibleRect.right && regFirst.top - height > visibleRect.top ) {
            $tooltip.css({
                left: regFirst.right,
                top: regFirst.top - height
            });        
            
        // Влево-вверх
        } else if (regFirst.left - width > visibleRect.left && regFirst.top - height > visibleRect.top ) {
            $tooltip.css({
                left: regFirst.left - width,
                top: regFirst.top - height
            });       
        // Внизу-слева
        } else if (regLast.left - width > visibleRect.left && regLast.bottom + height < visibleRect.bottom ) {
            $tooltip.css({
                left: regLast.left - width,
                top: regLast.bottom
            });            
        }
        
    }
    
    var hide = function() {
        if($tooltip) {
            $tooltip.stop(true).fadeOut("fast");
        }
    }

    $(document).on("mouseover", function(event) {
        var $e = $("#fuckoff"); // несуществующий элемент :)
        $(event.target).parents().andSelf().each(function() {
            if($(this).attr("data:tooltip")) {
                $e = $(this);
            }
        });
        if($e.length) {
            show($e.get(0).getClientRects(), $e.attr("data:tooltip"));
        }
    });
    
    $(document).on("mouseout", function(event) {
        var $e = $("#fuckoff"); // несуществующий элемент :)
        $(event.target).parents().andSelf().each(function() {
            if($(this).attr("data:tooltip")) {
                $e = $(this);
            }
        });
        if($e.length) {
            hide();
        }
    });

});