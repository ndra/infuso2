$(function() {

    $(document).click(function(event) { 
        if($(event.target).parents().index($('.userChooser-r5rr523ugt')) == -1) {
            if($('.user-select-zaqfrsj6nf').is(":visible")) {
                $('.user-select-zaqfrsj6nf').hide();
            }
        }        
    })
    
    $(".user-select-zaqfrsj6nf .item").click(function() {
        
        var userId = $(this).attr("user:id");
        var src = $(this).find("img").attr("src");
        var nick = $(this).find("div").text();
        
        $(this).trigger("userSelected", {
            userId: userId,
            userPic: src,
            nick: nick
        });
        
        $(this).parent().hide();
        
    });
});