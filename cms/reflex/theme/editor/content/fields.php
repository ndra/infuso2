<?

$id = get_class($editor).":".$editor->itemID();
<form class='svfo38b38d' infuso:id='{$id}' >

    $editor->templateEditForm()->exec();
    
    <div style='padding-left:200px;' >
        <input type='submit' value='Сохранить' />
    </div>
    
</form>