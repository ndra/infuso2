<? 

<div class='mwf8wqyh3i' data:theme='{e(get_class($theme))}' >

    <div class='toolbar' >
    
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("plus")
            ->air()
            ->addClass("add")
            ->exec();
            
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("trash")
            ->air()
            ->addClass(".refresh")
            ->exec();
    
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("refresh")
            ->air()
            ->addClass(".refresh")
            ->exec();
    </div>

    <div class='files' >
    
        <div class='node list-item' data:theme='{get_class($theme)}' data:id='/' >        
            $icon = $this->bundle()->path()."/res/img/icons16/template.gif";
            <div class='body' style='background-image:url({$icon})' >
                <span class='expander' ></span>
                <span class='name' >/</span>
            </div>
            <div class='subdivisions' style='display:block;' >
                exec("nodes", array(
                    "template" => $theme->template("/"),
                ));
            </div>
        </div>
    </div>
    
</div>