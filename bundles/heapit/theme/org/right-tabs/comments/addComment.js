$(function(){
    $(".add-comment-sldsjsct4f").mod("init", function(){
        var commentBlock = $(this).find(".comment-block");
        var button = $(this).find(".add-comment");
        console.log(button);
        button.click(function(event){
            event.preventDefault();
            console.log(1);
            var text = commentBlock.val();
            if(text){
                mod.call({
                    cmd: "infuso/heapit/controller/comments/addComment",
                    text: commentBlock.val(),
                    userId: $(this).attr("data:userId") 
                }, function(ret){
                    console.log(ret);    
                });
            }    
        });    
    });
});