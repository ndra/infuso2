<? 

<div class='ddksfajhjz' data:task='{$task->id()}' style='height:100%;' >

    exec("header");

    exec("form");
    
    <div style='padding: 0 20px;' >
        exec("files");  
    </div>
    
    exec("timeline");
    
    $inject = "";
    if($task->data("status") == \Infuso\Board\Model\Task::STATUS_DRAFT) {
        $inject = "display: none";
    }
    
    <div class='comments-container' style='{$inject}' >
        exec("/board/shared/comments");  
    </div>

</div>