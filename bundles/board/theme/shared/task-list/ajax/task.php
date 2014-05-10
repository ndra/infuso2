<? 

$h = helper("<div>");
$h->addClass("task");
$h->addClass("i95bnu5fvm");
$h->attr("data:id", $task->id());
$h->style("background", $task->data("color"));
if($task->paused()) {
    $h->style("height", 100);
}
$h->begin();

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