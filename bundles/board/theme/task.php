<? 

<form class='ybslv95net' >
    
    widget("infuso\\cms\\ui\\widgets\\textfield")
        ->value($task->data("text"))
        ->fieldName("text")
        ->exec();
        
    widget("infuso\\cms\\ui\\widgets\\textfield")
        ->value($task->data("timePlanned"))
        ->fieldName("timePlanned")
        ->exec();
        
    widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Сохранить")
        ->attr("type", "submit")
        ->exec();
    
</form>