<?

$item = $editor->item();

<div class='a5mJFdwVMY list-item' data:id='{$editor->id()}' >

    <a href='{$editor->url()}' >
    
        $preview = $item->photos()->one()->pdata("photo")->preview(32,32)->crop();
        <img src='{$preview}' align='absmiddle' />
    
        echo $editor->title();
    </a> 
    
</div>