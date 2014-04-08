$(function(){
    var refusalDescription = function() {
        console.log("ololo");
        var row = $(".bargian-form-bsszqf8kse .refusalDescription");
        var select = $(".bargian-form-bsszqf8kse select[name='status']");
        if(select.val() == 400){
            row.show();    
        }   
    }
    refusalDescription();
    $(".bargian-form-bsszqf8kse select[name='status']").change(refusalDescription);
});