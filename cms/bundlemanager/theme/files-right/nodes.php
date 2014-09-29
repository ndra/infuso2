<? 

<div class='zjvrux95g2' >
    foreach($path->dir()->sort() as $file) {
        <div class='node list-item' data:id='{$file}' data:folder='{$file->folder()}' >        
            $icon = \file::get("/")->preview(16,16);
            <div class='body' style='background-image:url({$icon})' >
                if($file->folder()) {
                    <span class='expander' ></span>
                } else {
                    <span class='expander-spacer' ></span>
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