<? 

<div class='i00sceaxx3' >

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
        $path = \file::get($bundle->path());
        exec("nodes", array(
            "path" => $path,
        ));
    </div>
    
</div>