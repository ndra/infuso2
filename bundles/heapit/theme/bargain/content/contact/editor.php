<?

lib::modjs();

<form class='gOuxIB8D7X' data:bargain='{$bargain->id()}' >
    
    widget("infuso\\cms\\ui\\widgets\\datepicker")
        ->value($bargain->data("callTime"))
        ->fieldName("callTime")
        ->fastDayShifts(array(
            \util::now()->stamp() => "Сегодня",
            \util::now()->shiftDay(1)->stamp() => "Завтра",
            \util::date(strtotime("monday"))->stamp() => "В понедельник",
            \util::now()->shiftDay(14)->stamp() => "Через две недели",
        ))->exec();
        
    <div style='height:10px;' ></div>
        
    widget("infuso\\cms\\ui\\widgets\\textarea")
        ->style("width", "100%")
        ->style("display", "block")
        ->fieldName("comment")
        ->placeholder("Причина переноса")
        ->exec();
        
    <div style='height:10px;' ></div>
        
    widget("infuso\\cms\\ui\\widgets\\button")
        ->submit()
        ->text("Сохранить")
        ->exec();    
    
</form>