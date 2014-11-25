<? 

if($task->timeSpent() + $task->timeSpentProgress() == 0) {
    return false;
}

<div class='hhraxv0jki' >

    echo "Потрачено ";
    echo $task->timeSpent();
    echo " + ";
    echo round($task->timeSpentProgress() / 3600, 2);
    echo " из ";
    echo $task->timeScheduled();
    
    widget("infuso\\board\\widget\\timeline")
        ->taskId($task->id())
        ->exec();

</div>