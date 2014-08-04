<? 

<div class='task i95bnu5fvm task-{$task->id()}' data:id='{$task->id()}' data:url='{$task->url()}' >

    //<div class='extra' ></div>
    
    $h = helper("<div>");
    $h->addClass("sticker");
    $h->style("background", \Infuso\Board\Color::get($task->project()->id()));
    if($task->data("group")) {
        $h->style("border-radius", "40px");
        $h->addClass("group");
    }
    $h->begin();
    
        if($task->data("status") == \Infuso\Board\Model\Task::STATUS_CANCELLED) {
            <div style='position: absolute; left: 0; top: 0; width: 100%; height: 100%;font-size:150px;line-height:.8;text-align: center;' >&times;</div>
        }
        
        if($task->data("status") == \Infuso\Board\Model\Task::STATUS_COMPLETED) {
            <div style='position: absolute; left: 0; top: 0; width: 100%; height: 100%;font-size:150px;line-height:.8;text-align: center;' >&#10003;</div>
        }

        <div class='title' >{$task->id()}. {$task->project()->title()}</div>
        
        exec("files");
        
        $size = 10;
        if(mb_strlen($task->data("text"),"utf-8") < 80) {
            $size = 14;
        }
        if(mb_strlen($task->data("text"),"utf-8") < 40) {
            $size = 18;
        }
        
        $comment = null;
        $logItem = $task->getLog()->eq("type", \Infuso\Board\Model\Log::TYPE_TASK_REVISED)->one();
        if($logItem->exists()) {
            $comment = $logItem->data("text");
        }
    
        <div class='text' style='font-size:{$size}px;' >
            if($comment) {
                <span class='comment' >{$comment}</span>
            }
            echo \util::str($task->data("text"))->hyphenize();
        </div>
        
    $h->end();
    
    exec("bottom-info");
    
</div>