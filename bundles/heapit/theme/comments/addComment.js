mod(".add-comment-rz7kt16k3a").init(function(){
    var commentBlock = $(this).find(".comment-block");
    var button = $(this).find(".add-comment");
    button.click(function(event){
        event.preventDefault();
        var text = commentBlock.val();
        if(text){
            mod.call({
                cmd: "infuso/heapit/controller/comments/addComment",
                text: commentBlock.val(),
                userId: $(this).attr("data:userId"),
                parent: $(this).attr("data:parent")  
            }, function(ret){
                commentBlock.val("");
                mod.fire("comments/update-list");   
            });
        }    
    });    
});