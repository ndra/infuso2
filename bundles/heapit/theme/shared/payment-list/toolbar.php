<? 

<div class='g-toolbar c-toolbar payment-toolabr-ah3hf8pqdk' >

    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->addClass("quicksearch")
        ->clearButton()
        ->exec();
        
    widget("\\infuso\\cms\\ui\\widgets\\datepicker")
        ->clearButton()    
        ->fieldName("from")    
        ->placeholder("от")
        ->exec();
        
    widget("\\infuso\\cms\\ui\\widgets\\datepicker")
        ->clearButton()
        ->placeholder("до")
        ->fieldName("to")
        ->value(\util::now()->shiftDay(14))
        ->exec();
    
    exec("status");
        
    widget("\\infuso\\cms\\ui\\widgets\\pager")
        ->fieldName("pager")
        ->addClass("pager")
        ->exec();

</div>