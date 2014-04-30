<?

<form class='mm4tqxw2gk' infuso:constructor='{$editor->itemID()}' >

    $tmp = $editor->item()->collection()->editor()->templateEditForm();
    $tmp->exec();
    
    <div style='padding-left:200px;padding-top:15px;' >
        widget("\\infuso\\cms\\ui\\widgets\\button")
            ->text("Сохранить")
            ->attr("type", "submit")
            ->exec();
    </div>

</form>