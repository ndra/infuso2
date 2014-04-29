<? 

<div class='g-toolbar c-toolbar task-toolbar-s88w4h5tpq' >

    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->addClass("quicksearch")
        ->clearButton()
        ->exec();
        
    exec("projects"); 
    
    widget("\\infuso\\cms\\ui\\widgets\\pager")
        ->fieldName("pager")
        ->addClass("pager")
        ->exec();   
    
</div>