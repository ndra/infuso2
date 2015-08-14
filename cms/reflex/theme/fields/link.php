<?
$editorInfo = get_class($editor).":".$editor->itemId();  
<div class='x4qRpzOJXG' data:editor='{$editorInfo}' data:field='{$field->name()}'>
    <input type='hidden' name='{$field->name()}' value='{$field->value()}' />
    <span class='title' >{$field->pvalue()->title()}</span>
    echo " Выбрать&nbsp;";
    
    if($field->value()){
        $editor = \Infuso\CMS\Reflex\Editor::get($editorInfo);
        $item = $editor->item();
        $link = $item->pdata($field->name());
        $url = $link->plugin("editor")->url();    
        <a href='{$url}' class="view" taget="_blank">Посмотреть</a>
    }    
</div>