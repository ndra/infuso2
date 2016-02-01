<? 

<div class='bk3fvoznwu' >

    /*if($field->editable()) {
        <input name='{$field->name()}' value='{e($field->value())}' />
    } else {
        <input value='{e($field->value())}' disabled />
    } */
    
    $w = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->value($field->value())  
        ->style("width", 80)
        ->fieldName($field->name());
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
        
    $w->exec();
        
    
</div>