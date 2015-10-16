<?

// Выводим все поля кроме поля "Значение"
if(\Infuso\Core\Superadmin::check()) {
    foreach($editor->item()->fields() as $field) {
        if($field->visible() || $field->editable()) {
            
            if($field->name() != "value") {
                $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
                $view->setEditor($editor);
        
        		app()->tm("/reflex/fields/field-layout")->param(array(
                    "label" => $field->label(),
                    "view" => $view,
                ))->exec();	
            
            }
        }
    }   
}

try {
    $field = $editor->item()->pdata("type");
    $field->setModel($editor->item());
    $field->name("value");
    $field->label("Значение");
    $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
    $view->setEditor($editor);
    
    app()->tm("/reflex/fields/field-layout")->param(array(
        "label" => $field->label(),
        "view" => $view,
    ))->exec();	
} catch (\Exception $ex) {
    echo "Редактирование недоступно";
}