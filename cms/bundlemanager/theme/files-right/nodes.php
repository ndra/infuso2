<? 

<div class='zjvrux95g2' >
    foreach($path->dir()->sort() as $file) {
        <div class='node' >        
            <div class='body list-item' data:id='{$file}' >
                <span class='expander' >+</span>
                <span class='name' >{$file->name()}</span>
            </div>
            if($file->folder()) {
                <div class='subdivisions' >
                    exec("/bundlemanager/files-right/nodes", array(
                        "path" => $file,
                    ));
                </div>
            }
        </div>
    }
</div>