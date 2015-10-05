<?
$editorInfo = get_class($editor).":".$editor->itemId();  
<div class='x4qRpzOJXG' data:editor='{$editorInfo}' data:field='{$field->name()}'>
    <input type='hidden' name='{$field->name()}' value='{$field->value()}' />
	$title = $field->pvalue()->title();
	if ($title == ""){
		$title = "пусто";   	
	}
    <span class='title' >{$title}</span>
    
    if($field->value()){
        $editor = \Infuso\CMS\Reflex\Editor::get($editorInfo);
        $item = $editor->item();
        $link = $item->pdata($field->name());
        $url = $link->plugin("editor")->url();    
        <a href='{$url}' class="view" taget="_blank"></a>
    }    
</div>
