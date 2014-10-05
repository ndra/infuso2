<?

<form class='B5AhPI5rlz' data:id='{$comment->id()}' >
    
    widget("infuso\\cms\\ui\\widgets\\textarea")
        ->style("width", "100%")
        ->value($comment->data("text"))
        ->fieldName("text")
        ->exec();
        
    widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Сохранить")
        ->attr("type", "submit")
        ->exec();
        
</form>