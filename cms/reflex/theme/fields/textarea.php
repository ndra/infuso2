<? 

<table class='f0rw8hlkvh' >
    <tr>
        <td class='label' >{$field->label()}</td>        
        $value = util::str($field->value())->esc();
        
        <td>
        if($field->editable()) {
            <textarea>
                echo $value;
            </textarea>
        } else {
            <textarea disabled>
                echo $value;
            </textarea>
        }
        </td>
        
    </tr>
</table>