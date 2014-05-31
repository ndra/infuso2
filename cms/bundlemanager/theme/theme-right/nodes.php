<? 

if(!$path) {
    $templates = array();
    foreach($theme->templates() as $template) {
        if($template->themeDepth() == 1) {
            $templates[] = $template;
        }
    }
} else {
    $templates = $theme->template($path)->children();
}

<div class='gdiqqd1vn4' >

    // Выводим корень
    if(!$path) {
        <div class='node list-item' data:theme='{get_class($template->theme())}' data:id='/' >   
            $icon = $this->bundle()->path()."/res/img/icons16/template.gif";
            <div class='body' style='background-image:url({$icon})' >
                <span class='expander-spacer' ></span>
                <span class='name' >/</span>
            </div>
        </div>
    }

    foreach($templates as $template) {
        <div class='node list-item' data:theme='{get_class($template->theme())}' data:id='{$template->name()}' >        
            $icon = $this->bundle()->path()."/res/img/icons16/template.gif";
            $folder = sizeof($template->children());
            <div class='body' style='background-image:url({$icon})' >
                if($folder) {
                    <span class='expander' ></span>
                } else {
                    <span class='expander-spacer' ></span>
                }
                <span class='name' >{$template->lastName()}</span>
            </div>
            <div class='subdivisions' >
                // ajax here
            </div>
        </div>
    }
</div>