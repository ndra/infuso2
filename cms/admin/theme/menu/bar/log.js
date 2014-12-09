mod.init(".ahkzj6jdb", function() {
    
    var $container = $(this);
    $container.click(function() {
        var $content = $.window({
            width: 600,
            height: 400,
            title: "Ололо!"
        }).window("contentElement");
        
        $content.html("");
        
        for(var i in mod.messages) {
            var message = mod.messages[i];
            var $table = $("<table>")
                .css({
                    tableLayout: "fixed",
                    width: "100%"
                }).appendTo($content);
            var $tr = $("<tr>")
                .appendTo($table);
                
            var time = "";
            time
                
            $("<td>")
                .css({
                    width: 50,
                    padding: 4,
                    opacity: .5
                }).html(time)
                .appendTo($tr);
                
            $("<td>")
                .css({
                    width: "100%",
                    padding: 4
                }).html(message.text + "")
                .appendTo($tr);
        }
        
        
    });
    
});