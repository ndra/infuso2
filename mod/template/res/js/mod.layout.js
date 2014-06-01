jQuery.fn.layout = function(p1) {

    if(p1 === undefined) {
        jQuery.fn.layout.watchlist.push(this);
    }
    
    if(p1 === "update") {
        jQuery.fn.layout.update();
    }
    
}

jQuery.fn.layout.watchlist = [];

jQuery.fn.layout.update = function() {

    var elementLayoutHash = function(e) {
        return $(e).width() + ":" + $(e).height();            
    }

    var updateElementStyle = function(e,css) {
        var hash1 = elementLayoutHash(e);
        $(e).css(css);
        var hash2 = elementLayoutHash(e);
        if(hash1 != hash2) {        
            $(e).filter(".layout-change-listener").trigger("layoutchange");
            $(e).find(".layout-change-listener").trigger("layoutchange");
        }
    }

    for(var i in jQuery.fn.layout.watchlist) {
    
        var $container = $(jQuery.fn.layout.watchlist[i]);
    
        $container.css({
            position: "relative"
        });
        
        var $left = $container.children(".left");
        var $right = $container.children(".right");
        var $top = $container.children(".top");
        var $bottom = $container.children(".bottom");
        var $center = $container.children(".center");
        
        $top.css("box-sizing", "border-box");
        $bottom.css("box-sizing", "border-box");
        $left.css("box-sizing", "border-box");
        $right.css("box-sizing", "border-box");            
        $center.css("box-sizing", "border-box");
        
        var left = 0;
        var top = 0;
        var right = 0;
        var bottom = 0;
        
        var width = $container.width();
        var height = $container.height();
        
        $top.each(function(n) {
            updateElementStyle(this, {
                position: "absolute",
                left: left,
                top: top,
                width: width
            });                
            top += $(this).outerHeight();
            height -= $(this).outerHeight();
        });
        
        $bottom.each(function(n) {
            updateElementStyle(this, {
                position: "absolute",
                left: left,
                bottom: bottom,
                width: width
            });                
            bottom += $(this).outerHeight();
            height -= $(this).outerHeight();
        });
        
        $left.each(function(n) {
            updateElementStyle(this, {
                position: "absolute",
                left: left,
                top: top,
                height: height
            });
            
            left += $(this).width();
            width -= $(this).width();
        });
        
        $right.each(function(n) {
            updateElementStyle(this, {
                position: "absolute",
                right: right,
                top: top,
                height: height
            });
            
            right += $(this).width();
            width -= $(this).width();
        });  
        
        $center.each(function() {
            updateElementStyle(this, {
                position: "absolute",
                left: left,
                top: top,
                width: width,
                height: height
            });
        });       
    }

}
           
jQuery.fn.layout.update();
setInterval(jQuery.fn.layout.update, 1000)