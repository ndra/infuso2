<?

<form class='ybslv95net' data:task='{$task->id()}' >
    
    <div style='border-bottom: 1px solid #ccc;' >
        widget("infuso\\cms\\ui\\widgets\\textarea")
            ->value(trim($task->data("text")))
            ->fieldName("text")
            ->placeholder("Описание задачи")
            ->style("width", "100%")
            ->style("display", "block")
            ->style("border", "none")
            ->style("font-family", "Arial")
            ->style("border-radius", 0)
            ->exec();
    </div>
    
    <div style='padding: 20px;' >
    
        <span class='deadline' >
            $id = "x".\util::id();
            <input type='checkbox' id='{$id}' />
            <label for='{$id}' >Дэдлайн</label>
        </span>
    
        widget("infuso\\cms\\ui\\widgets\\datepicker")
            ->value($task->data("timePlanned"))
            ->fieldName("timePlanned")
            ->exec();
            
        widget("infuso\\cms\\ui\\widgets\\button")
            ->text($task->exists() ? "Сохранить" : "Создать")
            ->attr("type", "submit")
            ->exec();
    </div>
    
</form>