<?
<div class='b-datefield-uS0gkzcIcA' >
    
    $w = widget("\\infuso\\cms\\ui\\widgets\\datepicker")
        ->value($field->value())        
        ->fieldName($field->name());
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
        
        
    $w->exec();
        
</div>
