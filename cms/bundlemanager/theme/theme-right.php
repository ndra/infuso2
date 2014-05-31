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
        exec("nodes", array(
            "theme" => $theme,
        ));
    </div>
    
</div>