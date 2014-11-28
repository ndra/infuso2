<?

<div class='ynRXmfiIV4' data:id='{$task->id()}' >

    <span class='do-comment' >Комментировать</span>

    <div class='comments-form' >
    
        $w = widget("\\infuso\\cms\\ui\\widgets\\textarea")
            ->style("width", "100%")
            ->style("display", "block")
            ->style("margin-bottom", 10)
            ->placeholder("Комментарий")
            ->exec();
            
        $w = widget("\\infuso\\cms\\ui\\widgets\\button")
            ->addClass("submit")
            ->text("Отправить")
            ->exec();
        
    </div>
    
</div>