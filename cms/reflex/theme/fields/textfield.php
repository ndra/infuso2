<? 

<table class='x8spq9pjwjn' >
    <tr>
        <td class='label' >{$field->label()}</td>        
        $value = util::str($field->value())->esc();
        
        <td>
        if($field->editable()) {
            <input name='{$field->name()}' value='{$value}' />
        } else {
            <input value='{$value}' disabled />
        }
        </td>
        
    </tr>
</table>