<? 

<div class='c-toolbar task-toolbar-s88w4h5tpq' >

    <h2>Бэклог</h2>

    if($status == "0" || $status == "check") {
        
        widget("\\infuso\\cms\\ui\\widgets\\textfield")
            ->addClass("quicksearch")
            ->clearButton()
            ->exec();
        
        widget("\\infuso\\cms\\ui\\widgets\\pager")
            ->fieldName("pager")
            ->addClass("pager")
            ->exec();
    }
    
</div>