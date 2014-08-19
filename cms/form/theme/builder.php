<?

$form = $builder->form();

foreach($form->fields()->editable() as $field) {
    <div>
        echo $field->label();
    </div>
}