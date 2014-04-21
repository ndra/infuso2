$(function() {
 
    $(".userChooser-r5rr523ugt .currentUser").click(function(event){
        var usersCont = $(".user-select-zaqfrsj6nf");
        $(".user-select-zaqfrsj6nf").show();
        var top = event.offsetY - usersCont.get(0).scrollHeight/2;
        var left = event.offsetX;
        usersCont.css({
            top: top,
            left: left
        });
    });
    
    $(".userChooser-r5rr523ugt").on("userSelected", function(event, params) {
        event.stopPropagation(); 
        $(this).find("input[type=hidden]").val(params.userId);
        $(this).find(".currentUser").find("img").attr("src", params.userPic); 
        $(this).find(".currentUser").find("div").text(params.nick);   
    });    
      
});
