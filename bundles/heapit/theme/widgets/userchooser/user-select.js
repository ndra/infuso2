$(function(){
    $(document).click(function(event) { 
        if($(event.target).parents().index($('.userChooser-r5rr523ugt')) == -1) {
            if($('.user-select-zaqfrsj6nf').is(":visible")) {
                $('.user-select-zaqfrsj6nf').hide();
            }
        }        
    })
    
    $(".user-select-zaqfrsj6nf .item").click(function(){
        var fieldName = $(this).parent().attr("userchooser:name");
        $("input[name='"+fieldName+"']").val($(this).attr("user:id"));
        var src = $(this).attr("src");
        $(".userChooser-r5rr523ugt .currentUser").attr("src", src);
        $(this).parent().hide(); 
    });
});