<? 

<div class='task i95bnu5fvm' data:id='{$task->id()}' data:url='{$task->url()}' >
    
    $h = helper("<div>");
    $h->addClass("sticker");
    $h->style("background", \Infuso\Board\Color::get($task->project()->id()));
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
       
        <div class='tools-wrapper' >
            <div class='tools' >
                $tools = $task->tools();
                foreach($tools as $section) {
                    foreach($section as $item) {
                        switch($item) {
                            case "take":
                                <input type='button' class='take' title='Взять задачу' />
                                break;
                        case "stop":
                                <input type='button' class='stop' title='Остановить' />
                                break;
                        case "done":
                                <input type='button' class='done' title='Задача выполнена' />
                                break;
                            case "resume":
                                <input type='button' class='resume' title='Возобновить задачу' />
                                break;
                            case "problems":
                                <input type='button' class='problems' title='Сообщить о проблеме' />
                                break;
                            case "cancel":
                                <input type='button' class='cancel' title='Отменить задачу' />
                                break;
                            default:
                                <input type='button' class='take' title='$item' />
                                break;
                        }
                    }
                }
            </div>
        </div>
        
    $h->end();
    
    exec("bottom-info");
    
</div>