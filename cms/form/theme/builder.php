<?

$form = $builder->form();
$id = "x".\util::id();

<form class='EW07Pdzytr' id='{$id}' method='post' >
    <table>
        foreach($form->fields()->editable() as $field) {
            <tr>
                <td>{$field->label()}</td>
                <td>
                    <input name='{$field->name()}' value='{e($field->value())}' />
                    <div class='error-msg error-{$field->name()}' ></div>
                </td>
            </tr>
        }
    </table>
    
    <input type='submit' />
    
    echo $builder->param("after");
    
</form>

$builder->bind("#{$id}");