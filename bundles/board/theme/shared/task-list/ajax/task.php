<? 

<div class="task i95bnu5fvm" data:id='{$task->id()}' >

    <div class='title' >{$task->id()}. {$task->project()->title()}</div>

    <div class='text' >
        echo \util::str($task->data("text"))->hyphenize();
    </div>
    
    exec("files");
    
    <div class='tools' ></div>
        
</div>