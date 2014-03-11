<?

$id = get_class($editor).":".$editor->itemID();
<form class='svfo38b38d' infuso:id='{$id}' >

    foreach($editor->item()->fields() as $field) {
        if($field->visible() || $field->editable()) {
            <div class='field-container' >
                $view = \Infuso\Cms\Reflex\FieldView\View::get($field);
                $view->template()->exec();
            </div>
        }
    }   
    
    <div style='padding-left:200px;' >
        <input type='submit' value='Сохранить' />
    </div>
    
</form>