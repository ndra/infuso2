<?

<div class='getcbtu0lh' >

    $storage = $editor->item()->storage();
    foreach($storage->files() as $file) {
        $preview = $file->preview(100,100);
        <div style='background:url($preview)' class='item' data:filename='{$file}' ></div>
    }
    
    <div class='stats' >
        echo \Infuso\Util\Units::formatBytes($storage->size());
        echo " в ".$storage->count()." файлов";    
    </div>

</div>