<? 

<div class='NxEX1Vh7h0' >

    $lastDate = null;
        
    foreach($task->getlog() as $item) {
        
        $date = $item->pdata("created")->date()->text();
        
        if($date != $lastDate) {
            <div class='date' >{$date}</div>
        }
        
        $lastDate = $date;
        
        <div class='comment' >
            <img align='absmiddle' style='margin-right:5px;' src='{$item->icon16()}' />
            <a class='user' href='{$item->user()->url()}' >{$item->user()->title()}</a>
            <span class='time' >{$item->pdata("created")->format("H:i")}</span>
            if($text = $item->data("text")) {
                <div class='text' >{$text}</div>
            }
        </div>
    }

</div>