<? 

<div class="task-list-zjnu1r2ofp" data:sortable='{$status == "0" ? 1 : 0}' >

    if($status == "0") {
        exec("groups");
    }

    if($status == "0" || $status == "1") {
        exec("plus");
    }

    switch($status) {
        
        default:
            foreach($tasks as $task) {
                exec("/board/shared/task-sticker", array(
                    "task" => $task,
                    "unique" => $task->data("unique"),
                ));
            }
            break;
            
        case 1:
            
            $taskList = array();
            foreach($tasks as $task) {
                $taskList[] = $task;
            }
            
            // Сортируем задачи так, чтобы выполняющиеся были впереди
            usort($taskList, function($a, $b) {
                $c1 = $a->activeCollaborators()->count() ? 1 : 0;
                $c2 = $b->activeCollaborators()->count() ? 1 : 0;
                if($c1 > $c2) {
                    return -1;
                }
                if($c1 < $c2) {
                    return 1;
                }
                return 0;
            });
            
            foreach($taskList as $task) {
                exec("/board/shared/task-sticker", array(
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