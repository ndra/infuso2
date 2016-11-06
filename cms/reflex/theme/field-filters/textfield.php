<?

<div class='l2bfEewpo6' >

    $w = widget("\\infuso\\cms\\ui\\widgets\\select")
        ->style("width", 90)
        ->values(array(
            "like" => "Содержит",
            "eq" => "Равно",
            "non-void" => "Заполнено",
            "void" => "Пусто",
        ));
    $w->exec();

    $w = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->addClass("input");
    $w->exec();
    
    <input type='idden' name='{$field->name()}' />
    
</div>
    