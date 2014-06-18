<? 

<div class='x8l0puejxv8' >
    
    foreach($task->collaborators() as $user) {
        <div>{$user->title()}</div>
    }
    
    /*$user = $task->responsibleUser();
    $preview = $user->userpic()->preview(16,16)->crop();
    
    <img src='{$preview}' align='absmiddle' style='margin-right:5px;' />
    echo $user->title();
    
    <span class='time' >
        echo $task->timeSpent();
        echo " / ";
        echo $task->timeScheduled();
    </span> */

</div>