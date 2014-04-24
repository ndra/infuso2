$(function() {

    var check = function() {
    
        $(".tob-bar-sr3yrzht3j a").each(function() {
            if(this.href==window.location.href) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        })
    
    }
    check();
    //setInterval(check,1000);

});