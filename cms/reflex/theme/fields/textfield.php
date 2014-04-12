<?

<div class='x8spq9pjwjn' >
    
    if($field->editable()) {
        <input name='{$field->name()}' value='{e($field->value())}' autocomplete="off" />
    } else {
        <input value='{e($field->value())}' disabled />
    }
        
</div>