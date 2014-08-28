<?

<div class='mcGSvrqQ3m task task-{$task->id()}' data:id='{$task->id()}' >

    <div class="folder">
        <div class="back"></div>
        <div class="front"></div>
    </div>
    
    <div class='content' >
    
        <div class='title' >{$task->data("text")}</div>
    
        for($i = 0; $i < $task->subtasks()->count(); $i ++ ) {
            <div class='subtask' ></div>
        }
    </div>
    
    <div class='edit' ></div>
    
</div>