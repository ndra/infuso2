<?

<div class='ynRXmfiIV4' data:id='{$task->id()}' >

    $w = widget("\\infuso\\cms\\ui\\widgets\\textarea")
        ->style("width", "100%")
        ->style("display", "block")
        ->style("margin-bottom", 10)
        ->exec();
        
    $w = widget("\\infuso\\cms\\ui\\widgets\\button")
        ->addClass("submit")
        ->text("Отправить")
        ->exec();
    
</div>