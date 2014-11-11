<?

<div class='mcGSvrqQ3m task' data:id='{$item->id()}' >
    $n = $item->count();
    $n = $n ? "($n)" : "";
    <div class='title' >{$item->title()} $n</div>
</div>