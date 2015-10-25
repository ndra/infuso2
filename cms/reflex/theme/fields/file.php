<? 

$editor = $view->editor();
$editor = get_class($editor).":".$editor->itemId();
<div class='l83i1tvf0u' data:editor='{$editor}' >
    <input type='hidden' name='{$field->name()}' value='{$field->value()}' />
    exec("ajax-preview");
    <div class='drag-splash' >
        <div class='text' >Перетащите файлы сюда</div>
    </div>
</div>