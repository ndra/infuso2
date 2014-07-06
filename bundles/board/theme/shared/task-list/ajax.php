<? 

<div class="task-list-zjnu1r2ofp" >

    <div style='font-size:24px;' >Бэклог</div>

    foreach($tasks as $task) {
        exec("task", array(
            "task" => $task,
        ));
    }
    
</div>