/*mod(".nM7Pgj0XX1").init(function() {
    
    var $container = $(this);
    
    $container.find(".preset").each(function() {
        
        var $e = $(this);
        
        //$(this).find(".bg1, .bg-2").each(function() {
        
        var a = [];
            
        for(var i = 0; i < 4; i ++) {
            a[i] = {
                transform: "rotate(" + Math.round(Math.random() * 360) + "deg)",
                //left: Math.round(Math.random() * 200 - 100),
                //top: Math.round(Math.random() * 200 - 100)
            };
            
        }
        
        $(this).find(".bg-1").css(a[0]);
        $(this).find(".bg-2").css(a[1]);
            
       // });
       
        $e.mouseenter(function() {
            $e.find(".bg-1").animate(a[2], "fast");
            $e.find(".bg-2").animate(a[3], "fast");
        }).mouseleave(function() {
            $e.find(".bg-1").css(a[0], "fast");
            $e.find(".bg-2").css(a[1], "fast");
        }); 
        

        
    });
    
    
});/