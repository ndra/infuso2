<?

<div class='wLGKYMEfER' >

    <form data:task='{$task->id()}' >
    
        widget("infuso\\cms\\ui\\widgets\\textfield")
            ->value(trim($task->data("text")))
            ->fieldName("text")
            ->placeholder("Название группы")
            ->exec();
        
        <div style='padding-top:20px;' ></div>
        
        <input id='xQ6zntBH5w' type='checkbox' />
        <label for='xQ6zntBH5w' >Только для проекта</label>
        
        <div style='padding-top:20px;' ></div>
        
        widget("infuso\\cms\\ui\\widgets\\button")
            ->text($task->exists() ? "Сохранить" : "Создать")
            ->attr("type", "submit")
            ->exec();
            
        widget("infuso\\board\\widget\\projectSelector")
            ->value(trim($task->data("text")))
            ->fieldName("text")
            ->exec();
            
    </form>

</div>