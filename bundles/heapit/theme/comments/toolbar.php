<? 
<div class='g-toolbar c-toolbar comments-toolbar-9mblmj0kwq'>
    widget("infuso\\cms\\ui\\widgets\\textfield")
    ->addClass("quicksearch")   
    ->placeholder("Найти сообщение")
    ->exec();
    
    widget("\\infuso\\cms\\ui\\widgets\\pager")
    ->fieldName("pager")
    ->addClass("pager")
    ->exec();
</div>