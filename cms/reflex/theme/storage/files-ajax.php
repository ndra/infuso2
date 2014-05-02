<?

<div class='getcbtu0lh' >

    $storage = $editor->item()->storage();
    foreach($storage->files() as $file) {
        <div class='item' >
            $preview = $file->preview(150,150);
            <div style='background:url($preview)' class='preview' data:filename='{$file}' ></div>
            
            <div class='name' >{$file->name()}</div>
            if($file->width()) {
                <div class='w-h' >{$file->width()} x {$file->height()}</div>
            }
            <div class='size' >{\Infuso\Util\Units::formatBytes($file->size())}</div>
        </div>
    }
    
    <div class='stats' >
        echo \Infuso\Util\Units::formatBytes($storage->size());
        echo " в ".$storage->count()." файлов";    
    </div>

</div>