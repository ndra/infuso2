<?

<div class='l2bfEewpo6' >

    if($value) {
        $value = json_decode($value, true);
    } else {
        $value = [];    
    }

    $select = widget("\\infuso\\cms\\ui\\widgets\\select")
        ->style("width", 90)
        ->values(array(
            "like" => "Содержит",
            "eq" => "Равно",
            "non-void" => "Заполнено",
            "void" => "Пусто",
        ));

    $input = widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->clearButton()
        ->addClass("input");
        
    $select->value($value["filter"]);
    $input->value($value["value"]);

    $select->exec();
    $input->exec();
    
    <input type='hidden' name='{$name}' />
    
</div>
    