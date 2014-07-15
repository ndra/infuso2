<?

$id = get_class($editor).":".$editor->itemID();
<form class='svfo38b38d' infuso:id='{$id}' >

    $editor->templateEditBeforeForm()->exec();
    $editor->templateEditForm()->exec();
    
    <div style='padding-left:200px;' >
        widget("\\infuso\\cms\\ui\\widgets\\button")
            ->text("Сохранить")
            ->attr("type", "submit")
            ->exec();
    </div>
    
</form>