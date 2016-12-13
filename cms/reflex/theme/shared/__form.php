<? 

foreach($editor->item()->fields() as $field) {
    if($field->visible() || $field->editable()) {
       
        $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
        $view->setEditor($editor);

		app()->tm("/reflex/fields/field-layout")->param(array(
            "label" => $field->label(),
            "view" => $view,
        ))->exec();		
        
    }
}   