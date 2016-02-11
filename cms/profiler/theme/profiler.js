mod.init(".nw5bny9hxyu6", function() {

    $(this).find(".a").click(function() {
        $(this).next().toggle("fast");
    });
    
    $(this).find(".close").click(function() {
        $(this).parent().parent().remove();
    });

})