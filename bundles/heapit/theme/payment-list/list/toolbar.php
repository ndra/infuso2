<? 

<div class='g-toolbar' >

    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->addClass("quicksearch")
        ->clearButton()
        ->exec();
        
    widget("\\infuso\\cms\\ui\\widgets\\pager")
        ->fieldName("pager")
        ->addClass("pager")
        ->exec();

</div>