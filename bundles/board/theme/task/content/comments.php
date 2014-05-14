<? 

<div class='rcog1oiaxe' >

    foreach($task->getlogCustom() as $item) {
        <div>
            <img src='{$item->icon16()}' />
            <span>{$item->pdata("created")->text()}</span>
            <a href='{$item->user()->url()}' >{$item->user()->title()}</a>
            //var_export($item->data());
        </div>
    }
    
</div>