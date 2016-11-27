<? 

$templates = $template->children();

<div class='gdiqqd1vn4' >

    foreach($templates as $template) {
        <div class='node list-item' data:theme='{get_class($template->theme())}' data:id='{$template->relName()}' >        
            $icon = $this->bundle()->path()."/res/img/icons16/template.gif";
            $folder = sizeof($template->children());
            <div class='body' style='background-image:url({$icon})' >
                if($folder) {
                    <span class='expander' ></span>
                } else {
                    <span class='expander-spacer' ></span>
                }
                <span class='name' >
                    echo $template->lastName();
                </span>
                if(trim($template->contents("js"))) {
                    <div class='js' >js</div>
                }
                if(trim($template->contents("css"))) {
                    <div class='css' >css</div>
                }
            </div>
            <div class='subdivisions' >
                // ajax here
            </div>
        </div>
    }
</div>