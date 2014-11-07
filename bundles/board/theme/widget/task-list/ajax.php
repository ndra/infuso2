<? 

<div class="task-list-zjnu1r2ofp" data:sortable='{$status == "backlog" ? 1 : 0}' >

    echo 121212121;

    switch($status) {
        
        default:
            foreach($tasks as $task) {
                exec("task", array(
                    "task" => $task,
                    "unique" => $task->data("unique"),
                ));
            }
            break;
            
        case "check":
            $last = null;
            foreach($tasks as $task) {
                
                $date = $task->pdata("changed")->date()->txt();
                if($last === null || $last != $date) {
                    <div class='date' >{$date}</div>
                    $last = $date;
                }
                exec("/board/shared/task-sticker", array (
                    "task" => $task,
                    "unique" => $task->data("unique"),
                ));
            }
            break;
            
    }
    
</div>