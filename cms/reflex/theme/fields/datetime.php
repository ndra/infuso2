<?
<div class='b-datetime-field-DDS1aSAThE' >
    
    
    $w = widget("\\infuso\\cms\\ui\\widgets\\datetime")
        ->param("timeEnabled", true)
        ->value($field->value())        
        ->fieldName($field->name());
        
    if(!$field->editable()) {
        $w->attr("disabled", true);
    }
        
        
    $w->exec();
      
</div>
