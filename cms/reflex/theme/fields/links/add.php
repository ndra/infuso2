<?

<div class='mQ2bn91Yw' data:editor='{get_class($editor)}:{$editor->itemId()}' data:field='{$field->name()}' >

    <div class='toolbar top' >
    
        widget("infuso\\cms\\ui\\widgets\\textfield")
            ->style("width", 150)
            ->placeholder("Найти элемент")
            ->clearButton()
            ->addClass("search")
            ->exec();
            
    </div>

    <div class='ajax center' >
        exec("ajax");
    </div>
    
</div>