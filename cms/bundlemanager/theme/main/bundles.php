<? 

<div class='erjk605ygl' >

    foreach(service("bundle")->all() as $bundle) {
        <div class='node' data:id='' >        
            $icon = $this->bundle()->path()."/res/img/icons16/template.gif";
            <div class='body' >
                <div class='expander' ></div>
                <div class='name' ><b>{$bundle->path()}</b></div>
            </div>
            <div class='subdivisions' >
            
                // Файлы
                <div class='node' >
                    <div class='body' >
                        <span class='expander-spacer' ></span>
                        <span class='name files' data:bundle='{$bundle->path()}' >Файлы</span>
                    </div>
                </div>  
                
                // Шаблоны
                foreach(service("classmap")->classes("Infuso\Template\Theme") as $class) {
                    $theme = new $class;
                    if($theme->bundle()->path() == $bundle->path()) {
                        //<div class='theme' data:theme='{get_class($theme)}' >{$theme->name()}</div>
                        <div class='node' >
                            <div class='body' >
                                <span class='expander-spacer' ></span>
                                <span class='name theme' data:theme='{get_class($theme)}' >{$theme->name()}</span>
                            </div>
                        </div>  
                    }
                }
                
            </div>
        </div>
    }
    
</div>