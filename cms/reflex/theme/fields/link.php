<?

$editorInfo = get_class($editor).":".$editor->itemId();  

$class = $field->editable() ? "x4qRpzOJXG" : "x4qRpzOJXG disabled";

<div class='{$class}' data:editor='{$editorInfo}' data:field='{$field->name()}'>

    // Скрытое поле для хранения значения
    
    if($field->editable()) {
        <input type='hidden' name='{$field->name()}' value='{$field->value()}' />
    }
    
    // Название
    
    $w = helper("<span class='title' />");
    $w->param("content", $field->pvalue()->title());
    if (!$field->pvalue()->exists()) {
        $w->style("display", "none");
    }
    $w->exec();
    
    // Надпись "Пусто"
    
    $w = helper("<span class='title-void' />");
    $w->param("content", "Пусто");
    if ($field->pvalue()->exists()) {
        $w->style("display", "none");
    }
    $w->exec();
    
    // Кнопка просмотра
    
    $editor = \Infuso\CMS\Reflex\Editor::get($editorInfo);
    $item = $editor->item();
    $link = $item->pdata($field->name());
    $url = $link->plugin("editor")->url();    
    $h = helper("<a href='{$url}' class='view' taget='_blank'></a>");
    if (!$field->pvalue()->exists()) {
        $h->style("display", "none");
    }
    $h->exec();
    
    // Кнопка очистки
    $h = helper("<span class='clear'></span>");
    if (!$field->pvalue()->exists()) {
        $h->style("display", "none");
    }
    $h->exec();
    
</div>
