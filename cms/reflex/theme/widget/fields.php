<?

foreach($fields as $field) {
       
    $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
    $view->setEditor($editor);

	app()->tm("/reflex/fields/field-layout")->param(array(
        "label" => $field->label(),
        "view" => $view,
    ))->exec();		
        
}