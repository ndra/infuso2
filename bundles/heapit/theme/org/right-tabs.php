<? 

<div class='l5n7igxids' >
    //<span>Заметки</span>
    //<span>Платежи</span>
    
    $tabs = widget("tabs");
    
    $tabs->tab("заметки");
    
        exec("comments");
        
    $tabs->tab("Платежи");
    
        exec("payments");
        
    $tabs->exec();
    
    
</div>