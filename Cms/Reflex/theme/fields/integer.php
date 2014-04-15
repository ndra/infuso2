<? 

<div class='bk3fvoznwu' >

    if($field->editable()) {
        <input name='{$field->name()}' value='{$field->value()}' type='number' />
    } else {
        <input value='{$value}' disabled />
    }
    
</div>