mod.init(".ynRXmfiIV4", function() {
    
    var $container = $(this);
    var $textarea = $container.find("textarea");
    var $submit = $container.find(".submit");
    
    var send = function() {
        var text = $textarea.val();
        if(!text) {
            return;
        }
        mod.call({
            cmd:"infuso/board/controller/log/send",
            taskId: $container.attr("data:id"),
            text: text
        });
        $textarea.val("");
    }
    
    $submit.click(send);
    
    $textarea.keydown(function(event) {
        if(event.which == 13 && event.ctrlKey) {
            event.preventDefault();
            send();
        }
    });
    
    $container.find(".do-comment").click(function() {
        $(this).hide();
        $container.find(".comments-form").show();
        $container.find("textarea").focus();
    });

});