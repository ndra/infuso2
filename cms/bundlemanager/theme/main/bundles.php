<? 

<div class='erjk605ygl' >
    
    foreach(service("bundle")->all() as $bundle) {
        <div class='bundle' >
            <div class='bundle-name' >{$bundle->path()}</div>
            <div class='subdivisions' >
                <div class='files' data:bundle='{$bundle->path()}' >Файлы</div>                
                // Шаблоны
                foreach(mod::service("classmap")->classes("Infuso\Template\Theme") as $class) {
                    $theme = new $class;
                    if($theme->bundle()->path() == $bundle->path()) {
                        <div class='theme' data:theme='{get_class($theme)}' >{$theme->name()}</div>
                    }
                }
            </div>
        </div>
    }
    
</div>