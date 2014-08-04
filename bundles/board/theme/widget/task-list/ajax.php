<? 

<div class="task-list-zjnu1r2ofp" data:sortable='{$status == "0" ? 1 : 0}' >

    if($status == "0") {
        exec("plus");
    }

    switch($status) {
        
        default:
            foreach($tasks as $task) {
                exec("task", array(
                    "task" => $task,
                    "changed" => $task->data("changed"),
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
                exec("task", array (
                    "task" => $task,
                    "changed" => $task->data("changed"),
                ));
            }
            break;
            
    }
    
</div>