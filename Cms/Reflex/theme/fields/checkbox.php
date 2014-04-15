<? 

$id = \util::id();
<div class='vgd2nzxvnn' >

    $inject = $field->value() ? "checked" : "";
    <input type='checkbox' id='{$id}' {$inject} />
    
    <label for='{$id}' >{$field->label()}</label>
    
    $val = $field->value();
    <input type='hidden' name='{$field->name()}' value='{$val}' >
</div> 