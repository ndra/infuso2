<?

<div class='IY8rTwBxKh' >

    <h1>{$group->title()}</h1>
    
    foreach($group->items() as $item) {
        <div class='item' >
            <a href='{$item->url()}' >
                $preview = $item->photos()->one()->pdata("photo")->preview(200,200);
                <img src='{$preview}' />
                <div class='title' >{$item->title()}</div>
            </a>
        </div>
    }

</div>