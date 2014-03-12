<? 

foreach($editor->item()->fields() as $field) {
    if($field->visible() || $field->editable()) {
        <div class='field-container' >
            $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
            $view->template()->exec();
        </div>
    }
}   