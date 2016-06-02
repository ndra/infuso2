<?

<form class='aJU0yhVtJ6' data:task='{$task->id()}' >

    widget("infuso\\cms\\ui\\widgets\\textarea")
        ->style("width", "100%")
        ->placeholder("Описание проблемы")
        ->exec();
        
    widget("infuso\\cms\\ui\\widgets\\button")
        ->attr("type", "submit")
        ->text("Отправить")
        ->exec();

</form>