<?

<div class='ttbuu8389u' data:task='{$task->id()}' >

    $tools = $task->tools();
    
    foreach($tools as $section) {
        foreach($section as $item) {
            switch($item) {
                case "take":
                    <input type='button' class='take' title='Взять задачу' />
                    break;
                case "pause":
                    <input type='button' class='pause' title='Поставить задачу на паузу' />
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
                case "revision":
                    <input type='button' class='revision' title='Отправить на доработку' />
                    break;
                case "problems":
                    <input type='button' class='problems' title='Сообщить о проблеме' />
                    break;
                case "cancel":
                    <input type='button' class='cancel' title='Отменить задачу' />
                    break;
                case "complete":
                    <input type='button' class='complete' title='$item' />
                    break;
                case "problem":
                    <input type='button' class='problem' title='$item' />
                    break;
                default:
                    Throw new \Exception("Task tools: unknown button $item!");
                    break;
            }
        }
    }
</div>