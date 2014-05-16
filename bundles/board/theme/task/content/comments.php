<? 

<div class='rcog1oiaxe layout' style='height: 100%;' >

    <div class='top g-toolbar' >ололо!</div>    

    <div class='center' style='overflow: auto;' >
        foreach($task->getlogCustom() as $item) {
            <div style='margin-bottom:50px;' >
                <img src='{$item->icon16()}' />
                <span>{$item->pdata("created")->text()}</span>
                <a href='{$item->user()->url()}' >{$item->user()->title()}</a>
                //var_export($item->data());
            </div>
        }
    </div>
    
    <div class='bottom' style='background: red;' >
        $w = widget("\\infuso\\cms\\ui\\widgets\\textarea")
            ->style("width", 200)
            ->style("display", "block")
            ->style("width", "100%")
            ->exec();
    </div>    
    
</div>