mod.init(".Efjz1xPdzl", function() {
    
    var $container = $(this);
    
    var makeid = function() {
        var text = "x";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
    
        for( var i=0; i < 10; i++ ) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
    
        return text;
    }
    
    var id = makeid();
    
    $container.attr("id", id);
    
    /* $container.find(".bg-1, .bg-2, .bg-3").each(function() {
        $(this).css("background", $container.css("border-color"));
    }); */
    
    var style = "";
    for(var i = 1; i <= 1; i ++) {
        
        var r = (Math.random()*360);
        
        style += "#" + id + " .bg-" + i + " {";
        style += "background: " + $container.css("border-color") + ";";
       // style += "left: " + (Math.random() * 100 - 150) + "%;";
      //  style += "top: " + (Math.random() * 100 - 50) + "%;";
      //  style += "transform: rotate(" + r + "deg);";
        style += "}";
        
        style += "#" + id + ":hover .bg-" + i + " {";
        style += "background: " + $container.css("border-color") + ";";
       // style += "left: " + (Math.random() * 200 - 100) + "%;";
      //  style += "top: " + (Math.random() * 200 - 100) + "%;";
        //style += "transform: rotate(" + (r + Math.random()*200 - 100) + "deg);";
        style += "}";
    }
    $("<style>").html(style).appendTo("head");
    
    /*$container.find(".bg-1").css({
        left: (Math.random() * 100 - 50) + "%",
        top: (Math.random() * 100 - 50) + "%",
        transform: "rotate(" + (Math.random()*360) + "deg)"
    });
    
    $container.find(".bg-2").css({
        left: (Math.random() * 100 - 50) + "%",
        top: (Math.random() * 100 - 50) + "%",
        transform: "rotate(" + (Math.random()*360) + "deg)"
    });
    
    $container.find(".bg-3").css({
        left: (Math.random() * 100 - 50) + "%",
        top: (Math.random() * 100 - 50) + "%",
        transform: "rotate(" + (Math.random()*360) + "deg)"
    }); */

});