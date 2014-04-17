<?

<div class='x8spq9pjwjn' >
    
    /*if($field->editable()) {
        <input name='{$field->name()}' value='{e($field->value())}' autocomplete="off" />
    } else {
        <input value='{e($field->value())}' disabled />
    } */
    
    $w = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->value($field->value())        
        ->fieldName($field->name());
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
        
        
    $w->exec();
        
</div>