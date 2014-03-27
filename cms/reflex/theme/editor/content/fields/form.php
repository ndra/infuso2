<? 

foreach($editor->item()->fields() as $field) {
    if($field->visible() || $field->editable()) {
       
        $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
        
        tmp::exec("/reflex/fields/field-layout" ,array(
            "label" => $field->label(),
            "view" => $view,
        ));    
        
    }
}   