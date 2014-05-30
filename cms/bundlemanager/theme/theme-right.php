<? 

<div class='mwf8wqyh3i' >

    <div class='toolbar' >
    
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("plus")
            ->air()
            ->addClass(".refresh")
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