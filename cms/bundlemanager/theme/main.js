$(function() {

    var updateHeight = function() {
    
        var y = $(".zdh71269gn").offset().top;
        var h = window.document.body.clientHeight - y;
        $(".zdh71269gn").css({
            minHeight: h
        });
    
    }
    
    updateHeight();
    setInterval(updateHeight,1000);

});