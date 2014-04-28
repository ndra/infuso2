$(function() {

    $(".s9nh9b1znm").mod("init", function() {

        var container = $(this);
        var textarea = container.find("textarea:first");
        
        var clone = null;
    
        var update = function() {
        
            if(clone) {
                clone.remove();
            }
        
            clone = textarea.clone()
                .appendTo(container)
                .val(textarea.val())
                .addClass("clone")
                
            var height = clone.get(0).scrollHeight;
            
            if(height > 400) {
                height = 400;
            }
            
            textarea.height(height);
            
            clone.remove();
        
        };
        
        update();
        setInterval(update, 1000);
        textarea.on("input cut paste",update);
    
    });


})