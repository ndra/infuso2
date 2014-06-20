<? 

<div class='pn2dSKDht6' >

    $w = widget("infuso\\cms\\ui\\widgets\\button")
        ->air()
        ->text("Просмотреть")
        ->addClass("view")
        ->attr("data:url", $editor->item()->url())
        ->exec();
        
    <span style='margin-right: 20px;' ></span>
        
    $w = widget("infuso\\cms\\ui\\widgets\\button")
        ->icon("trash")
        ->air()
        ->addClass(".refresh")
        ->exec();
    
</div>