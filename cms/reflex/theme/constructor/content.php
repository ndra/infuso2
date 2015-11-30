<?

<form class='mm4tqxw2gk' infuso:constructor='{$editor->itemID()}' >

    $destEditor = $editor->item()->collection()->editor();
    
    foreach($destEditor->item()->fields() as $field) {
        if($field->visible() || $field->editable()) {
           
            $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
            $view->setEditor($destEditor);
            $view->setStorageEditor($editor);
    
    		app()->tm("/reflex/fields/field-layout")->param(array(
                "label" => $field->label(),
                "view" => $view,
            ))->exec();		
            
        }
    }   
    
    <div style='padding-left:200px;padding-top:15px;' >
        widget("\\infuso\\cms\\ui\\widgets\\button")
            ->text("Сохранить")
            ->attr("type", "submit")
            ->exec();
    </div>

</form>