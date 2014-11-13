<?

$task = $item->task();

<div class='mcGSvrqQ3m task' data:id='{$task->id()}' data:group='{$item->id()}' >
    $n = $item->count();
    $n = $n ? "($n)" : "";
    <div class='title' >{$item->title()} $n</div>
</div>