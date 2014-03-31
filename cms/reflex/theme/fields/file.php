<? 

$editor = $view->editor();
$editor = get_class($editor).":".$editor->itemId();
<div class='l83i1tvf0u' data:editor='{$editor}' >
    <input name='{$field->name()}' value='{$field->value()}' />
    tmp::exec("ajax-preview");
</div>