<? 

<div class='bk3fvoznwu' >

    if($field->editable()) {
        <input name='{$field->name()}' value='{$field->value()}' />
    } else {
        <input value='{$value}' disabled />
    }
    
</div>