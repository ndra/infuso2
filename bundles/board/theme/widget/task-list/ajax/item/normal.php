<? 

$task = $item->task();

$class = "";
if($task->activeCollaborators()->count()) {
    $class.= " active";
}

<div class='task i95bnu5fvm task-{$task->id()} $class' data:id='{$task->id()}' >

    exec("big");
    
    exec("small");
    
</div>