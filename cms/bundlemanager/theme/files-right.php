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
        foreach(\file::get($bundle->path())->dir()->sort() as $file) {
            <div>{$file->name()}</div>
        }
    </div>
    
</div>