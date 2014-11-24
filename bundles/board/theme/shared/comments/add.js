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
        updateButtonVisibility();
    }
    
    $submit.click(send);
    
    $textarea.keypress(function(event) {
        if(event.which == 13 && !event.ctrlKey) {
            event.preventDefault();
            send();
        }
    });
    
    var updateButtonVisibility = function() {
        var val = $textarea.val();
        if(val.length) {
            $submit.show();
        } else {
            $submit.hide();
        }
    }
    
    $textarea.on("input", updateButtonVisibility);
    
});