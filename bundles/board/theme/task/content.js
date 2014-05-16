mod.init(".ddksfajhjz", function() {

    var container = $(this);

    // Перетаскивание файлов в браузер
    container.on("dragover", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass("drag-enter");
    });
    
    container.on("dragleave", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
    });
    
    container.on("drop", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
        var file = e.originalEvent.dataTransfer.files[0];            
        mod.call({
            cmd:"infuso/board/controller/attachment/upload",
            taskId: container.attr("data:task")
        }, function() {        
            container.find(".c-attachments").triggerHandler("board/upload");        
        }, {
            files: {
                file: file
            }
        });
        
    });
    
    var layout = function() {
    
        $(".layout").each(function() {
        
            $(this).css({
                position: "relative"
            });
            
            var $left = $(this).children(".left");
            var $right = $(this).children(".right");
            var $top = $(this).children(".top");
            var $bottom = $(this).children(".bottom");
            var $center = $(this).children(".center");
            
            $top.css("box-sizing", "border-box");
            $bottom.css("box-sizing", "border-box");
            $left.css("box-sizing", "border-box");
            $right.css("box-sizing", "border-box");            
            $center.css("box-sizing", "border-box");
            
            var left = 0;
            var top = 0;
            var right = 0;
            var bottom = 0;
            
            var width = $(this).width();
            var height = $(this).height();
            
            $top.each(function(n) {
                $(this).css({
                    position: "absolute",
                    left: left,
                    top: top,
                    width: width
                });                
                top += $(this).outerHeight();
                height -= $(this).outerHeight();
            });
            
            $bottom.each(function(n) {
                $(this).css({
                    position: "absolute",
                    left: left,
                    bottom: bottom,
                    width: width
                });                
                bottom += $(this).outerHeight();
                height -= $(this).outerHeight();
            });
            
            $left.each(function(n) {
                $(this).css({
                    position: "absolute",
                    left: left,
                    top: top,
                    height: height
                });
                
                left += $(this).width();
                width -= $(this).width();
            });
            
            $right.each(function(n) {
                $(this).css({
                    position: "absolute",
                    right: right,
                    top: top,
                    height: height
                });
                
                right += $(this).width();
                width -= $(this).width();
            });
            
            $center.each(function() {
                $(this).css({
                    position: "absolute",
                    left: left,
                    top: top,
                    width: width,
                    height: height
                });
            });
            
        });
    
    }
    
    layout();
    setInterval(layout, 1000);
    $(window).resize(layout);

});