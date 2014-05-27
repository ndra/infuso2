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
    


        $id = get_class($editor).":".$editor->itemID();
        <form class='meta-form' infuso:id='{$id}' >
        
            $metaEditor = \Infuso\CMS\Reflex\Editor::get("Infuso\\CMS\\Reflex\\Model\\MetaEditor:".$metaObject->id());
            exec("/reflex/shared/form", array(
                "editor" => $metaEditor,
            ));
            
            <div style='padding-left:200px;' >
                widget("\\infuso\\cms\\ui\\widgets\\button")
                    ->text("Сохранить")
                    ->attr("type", "submit")
                    ->exec();
            </div>
            
            <div>Удалить метаданные</div>
            
        </form>
    

    
    }
    
</div>