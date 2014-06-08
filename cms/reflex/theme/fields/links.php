<?

<div class='QWQ2cWdbx' data:editor='{get_class($editor)}:{$editor->itemId()}' data:field='{$field->name()}' >

    <input type='hidden' name='{$field->name()}' value='{e($field->value())}'/>

    <div class='ajax' >
        exec("ajax-items");
    </div>

    <div class='add' >Добавить</div>

</div>