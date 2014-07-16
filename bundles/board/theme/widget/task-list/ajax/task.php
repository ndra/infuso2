<? 

<div class='task i95bnu5fvm task-{$task->id()}' data:id='{$task->id()}' data:url='{$task->url()}' >

    //<div class='extra' ></div>
    
    $h = helper("<div>");
    $h->addClass("sticker");
    $h->style("background", \Infuso\Board\Color::get($task->project()->id()));
    if($task->data("group")) {
        $h->style("border-radius", "40px");
    }
    $h->begin();

        <div class='title' >{$task->id()}. {$task->project()->title()}</div>
        
        exec("files");
        
        $size = 10;
        if(mb_strlen($task->data("text"),"utf-8") < 80) {
            $size = 14;
        }
        if(mb_strlen($task->data("text"),"utf-8") < 40) {
            $size = 18;
        }
        
    
        <div class='text' style='font-size:{$size}px;' >
            echo \util::str($task->data("text"))->hyphenize();
        </div>
        
    $h->end();
    
    exec("bottom-info");
    
</div>