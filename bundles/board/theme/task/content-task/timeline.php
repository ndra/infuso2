<? 

if($task->timeSpent() + $task->timeSpentProgress() == 0) {
    return false;
}

<div class='hhraxv0jki' >

    <div class='time-text' >
        echo "Потрачено ";
        echo round($task->timeSpent() / 3600, 2);
        
        if($progress = round($task->timeSpentProgress() / 3600, 2)) {
            echo " + ";
            echo round($task->timeSpentProgress() / 3600, 2);
        }
        
        echo " из ";
        echo $task->timeScheduled();
        echo " ч";
        
    </div>
    
    widget("infuso\\board\\widget\\timeline")
        ->taskId($task->id())
        ->exec();

</div>