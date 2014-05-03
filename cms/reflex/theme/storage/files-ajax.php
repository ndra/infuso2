<?

exec("/reflex/layout/global");

<div class='getcbtu0lh' >

    $segments = trim($storage->relPath(), "/") ? explode("/",trim($storage->relPath(),"/")) : array();
    
    if(sizeof($segments)) {
        <div class='path' >
            <span class='back-path' data:path='/' >В корень</span>
            foreach($segments as $n => $segment) {
                if($n != sizeof($segments)) {
                    <span class='spacer' >/</span>
                }
                <span class='back-path' data:path='{implode("/",array_slice($segments,0,$n+1))}' >{$segment}</span>
            }
        </div>
    }    

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