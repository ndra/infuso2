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
    foreach($templates as $template) {
        <div class='node' >        
            //$icon = \file::get("/")->preview(16,16);
            <div class='body list-item' data:theme='{get_class($template->theme())}' data:id='{$template->name()}' style='background-image:url({$icon})' >
                <span class='expander' ></span>
                <span class='name' >{$template->lastName()}</span>
            </div>
            <div class='subdivisions' >
                // ajax here
            </div>
        </div>
    }
</div>