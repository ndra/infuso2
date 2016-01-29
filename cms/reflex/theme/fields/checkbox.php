<? 

$id = \util::id();
<div class='vgd2nzxvnn' >

    helper("<input type='checkbox' />")
        ->attr("id", $id)
        ->attr("checked", $field->value() ? "checked" : null)
        ->attr("disabled", !$field->editable() ? "disabled" : null)
        ->exec();
    
    $inject = $field->editable() ? "" : "class='disabled' ";
    <label {$inject} for='{$id}' {$inject} >{$field->label()}</label>
    
    $val = $field->value();
    <input type='hidden' name='{$field->name()}' value='{$val}' >
</div> 