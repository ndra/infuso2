<? 

<div class="task i95bnu5fvm" data:id='{$task->id()}' >

    <div class='title' >{$task->id()}. {$task->project()->title()}</div>

    <div class='text' >
        echo \util::str($task->data("text"))->hyphenize();
    </div>
    
    exec("files");
    
    <div class='tools-wrapper' >
        <div class='tools' >
            $tools = $task->tools();
            foreach($tools as $section) {
                foreach($section as $item) {
                    switch($item) {
                        case "take":
                            <input type='button' class='take' title='Взять задачу' />
                            break;
                        case "problems":
                            <input type='button' class='problems' title='Проблемы' />
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
        
</div>