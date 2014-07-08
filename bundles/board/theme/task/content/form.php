<?

<form class='ybslv95net' data:task='{$task->id()}' >
    
    <div style='border-bottom: 1px solid #ccc;' >
        widget("infuso\\cms\\ui\\widgets\\textarea")
            ->value($task->data("text"))
            ->fieldName("text")
            ->placeholder("Описание задачи")
            ->style("width", "100%")
            ->style("border", "none")
            ->style("font-family", "Arial")
            ->style("border-radius", 0)
            ->exec();
    </div>
    
    <div style='padding: 20px;' >
    
        /*widget("infuso\\cms\\ui\\widgets\\textfield")
            ->value($task->data("timePlanned"))
            ->fieldName("timePlanned")
            ->exec(); */
            
        widget("infuso\\cms\\ui\\widgets\\button")
            ->text($task->exists() ? "Сохранить" : "Создать")
            ->attr("type", "submit")
            ->exec();
    </div>
    
</form>