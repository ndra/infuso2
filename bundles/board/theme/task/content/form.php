<?

<form class='ybslv95net' data:task='{$task->id()}' >
    
    <div style='margin-bottom:10px;' >
        widget("infuso\\cms\\ui\\widgets\\textarea")
            ->value($task->data("text"))
            ->fieldName("text")
            ->style("width", 500)
            ->exec();
    </div>
        
    widget("infuso\\cms\\ui\\widgets\\textfield")
        ->value($task->data("timePlanned"))
        ->fieldName("timePlanned")
        ->exec();
        
    widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Сохранить")
        ->attr("type", "submit")
        ->exec();
    
</form>