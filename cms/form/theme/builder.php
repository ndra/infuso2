<?

$form = $builder->form();

<div class='EW07Pdzytr' >
    <table>
        foreach($form->fields()->editable() as $field) {
            <tr>
                <td>{$field->label()}</td>
                <td>
                    <input name='{$field->name()}' value='{e($field->value())}' />
                </td>
            </tr>
        }
    </table>
</div>