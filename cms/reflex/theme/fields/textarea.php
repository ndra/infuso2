<? 

<div class='f0rw8hlkvh' >

    $w = widget("\\infuso\\cms\\ui\\widgets\\textarea")
        ->value($field->value())        
        ->fieldName($field->name())
        ->style("width", "100%");
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
    
    $w->exec();

</div>