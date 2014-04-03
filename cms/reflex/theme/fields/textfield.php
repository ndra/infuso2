<?

<div class='x8spq9pjwjn' >

    $value = util::str($field->value())->esc();
    
    if($field->editable()) {
        <input name='{$field->name()}' value='{$value}' autocomplete="off" />
    } else {
        <input value='{$value}' disabled />
    }
        
</div>