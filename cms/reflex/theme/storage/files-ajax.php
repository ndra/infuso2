<?

exec("/reflex/layout/global");

<div class='getcbtu0lh' >

    <div class='path' >
        $segments = explode("/",trim($storage->relPath(),"/"));
        <span class='back-path' data:path='/' >/</span>
        foreach($segments as $n => $segment) {
            <span class='back-path' data:path='{implode("/",array_slice($segments,0,$n+1))}' >{$segment}</span>
        }
    </div>

    // Список файлов    
    foreach($storage->files() as $file) {
        
        $h = helper("<div>");
        $h->addCLass("list-item");
        if($file->folder()) {
            $h->addCLass("folder");            
        }
        
        $h->attr("data:id", $file->rel($storage->root()));
        $h->begin();
    
            $preview = $file->preview(150,150);
            <div style='background:url($preview)' class='preview' data:filename='{$file}' ></div>
            
            <div class='name' >{$file->name()}</div>
            if($file->width()) {
                <div class='w-h' >{$file->width()} x {$file->height()}</div>
            }
            
            <div class='size' >{\Infuso\Util\Units::formatBytes($file->size())}</div>
            
        $h->end();
    }
    
    // Подвал со статистикой
    
    <div class='stats' >
        echo \Infuso\Util\Units::formatBytes($storage->size());
        echo " в ".$storage->count()." файлов";    
    </div>

</div>