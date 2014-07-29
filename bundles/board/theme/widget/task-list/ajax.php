<? 

<div class="task-list-zjnu1r2ofp" >

    if($tasks->virtual()->data("status") == 0) {
        exec("plus");
    }

    foreach($tasks as $task) {
        exec("task", array(
            "task" => $task,
        ));
    }
    
</div>