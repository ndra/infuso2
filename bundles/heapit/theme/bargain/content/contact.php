<?

<div class='LPtmRzde2d' data:bargain='{$bargain->id()}' >

    <span style='margin-right:10px;' >Связаться {$bargain->pdata("callTime")->left()}</span>
    
    $w = widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Изменить")
        ->exec();
    
</div>