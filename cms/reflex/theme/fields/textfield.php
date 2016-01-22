<?

<div class='x8spq9pjwjn' >
    
    $w = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->value($field->value())        
        ->fieldName($field->name());
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
        
    $w->exec();
        
</div>