<?

<table class='QWQ2cWdbx' data:editor='{get_class($editor)}:{$editor->itemId()}' data:field='{$field->name()}' >
    <tr>
        <td class='ajax' >
            exec("ajax-items");
        </td>
        <td class='add' ></td>
    </tr>
    
    <tr style='display:none;' >
        <td>
            <input type='hidden' name='{$field->name()}' value='{e($field->value())}'/>
        </td>
    </td>
    
</table>