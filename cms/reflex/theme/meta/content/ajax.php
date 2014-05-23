<?

$item = $editor->item();
$metaObject = $item->plugin("meta")->metaObject(); 

<div class='lonjnbmi8k' data:index='{get_class($editor)}:{$editor->itemId()}' >

    if(!$metaObject->exists()) {
    
        <span>У объекта отсутствуют метаданные.</span>
        
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->text("Создать")
            ->addClass("create-meta")
            ->exec();
        
    } else {
    
        //echo $metaObject->prefixedTableName();
        
        exec("/reflex/shared/form");
        
    
    }
    
</div>