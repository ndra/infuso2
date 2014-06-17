mod.init(".ynRXmfiIV4", function() {
    
    var $container = $(this);
    var $textarea = $container.find("textarea");
    
    var send = function() {
        mod.call({
            cmd:"infuso/board/controller/log/send",
            taskId: $container.attr("data:id"),
            text: $textarea.val()
        });
        $textarea.val("");
    }
    
    $textarea.keypress(function(event) {
        if(event.which == 13 && !event.ctrlKey) {
            event.preventDefault();
            send();
        }
    });
    
});