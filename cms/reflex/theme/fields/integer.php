<? 

<div class='bk3fvoznwu' >

    if($field->editable()) {
        <input name='{$field->name()}' value='{e($field->value())}' />
    } else {
        <input value='e({$field->value()})' disabled />
    }
    
</div>