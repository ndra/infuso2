<? 

<div class='x8l0puejxv8' >
    
    foreach($task->activeCollaborators() as $user) {
        $userpic = $user->userpic()->preview(16,16)->crop();
        <img src='{$userpic}' title='{$user->title()}' />
    }
    
    <span class='time' >
    
        echo round($task->timeSpent() / 3600, 2);
        
        if($task->data("status") == \Infuso\Board\Model\Task::STATUS_IN_PROGRESS) {
            echo " + ";
            echo round($task->timeSpentProgress() / 3600, 2);
        }
        
        echo " / ";
        echo $task->timeScheduled();
        
    </span>

</div>