<?

<form class='BHiplt1wyh' data:task='{$task->id()}' >

    widget("infuso\\cms\\ui\\widgets\\textarea")
        ->style("width", "100%")
        ->placeholder("Причина доработки")
        ->exec();
        
    widget("infuso\\cms\\ui\\widgets\\button")
        ->attr("type", "submit")
        ->text("Отправить на доработку")
        ->exec();

</form>