<? 

$editor = get_class($editor).":".$editor->itemId();
<div class='x8gdq98zre1 c-toolbar' infuso:editor='{$editor}' >

    <input name='file' type='file' />
    
    widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Создать папку")
        ->addClass("createFolder")
        ->exec();
    
    <span class='with-selection' >
    
        widget("infuso\\cms\\ui\\widgets\\button")
            ->text("Выбрать")
            ->exec();
            
        widget("infuso\\cms\\ui\\widgets\\button")
            ->text("Скачать")
            ->addClass("download")
            ->exec();
            
        widget("infuso\\cms\\ui\\widgets\\button")
            ->text("Удалить")
            ->addClass("delete")
            ->exec();
    </span>
</div>