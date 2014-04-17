$(function() {

    var updateHeight = function() {
    
        var y = $(".x0h4tfwmhnn").offset().top;
        var h = window.document.body.clientHeight - y;
        $(".x0h4tfwmhnn").css({
            minHeight: h
        });
    
    }
    
    updateHeight();
    setInterval(updateHeight,1000);

});