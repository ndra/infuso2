<?

$item = $editor->item();
$route = \Infuso\Cms\Reflex\Model\Route::get($item);

<div class='ioy1gedqt1' data:editor='{$editor->id()}' >

    if($route->exists()) {
    
        widget("infuso\\cms\\ui\\widgets\\textfield")
            ->value($route->data("url"))
            ->addClass("url")
            ->exec();
            
            widget("infuso\\cms\\ui\\widgets\\button")
                ->text("Сохранить")
                ->addClass("save")
                ->exec();
                
            widget("infuso\\cms\\ui\\widgets\\button")
                ->text("Удалить адрес")
                ->addClass("delete")
                ->exec();
        
        
    } else {
        <div class='' >
            <span style='margin-right: 10px;' >Сейчас используется адрес по умолчанию: {$item->url()}</span>
            
            $w = widget("infuso\\cms\\ui\\widgets\\button")
                ->text("Изменить адрес")
                ->addClass("create-object")
                ->exec();
        </div>
    }

</div>