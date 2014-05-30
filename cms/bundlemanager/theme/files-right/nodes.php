<? 

<div class='zjvrux95g2' >
    foreach($path->dir()->sort() as $file) {
        <div class='node' >        
            $icon = \file::get("/")->preview(16,16);
            <div class='body list-item' data:id='{$file}' style='background-image:url({$icon})' >
                if($file->folder()) {
                    <span class='expander' ></span>
                }
                <span class='name' >{$file->name()}</span>
            </div>
            if($file->folder()) {
                <div class='subdivisions' >
                    // ajax here
                </div>
            }
        </div>
    }
</div>