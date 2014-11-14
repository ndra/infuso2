<? 

<div class='hhraxv0jki' >

    /*foreach($task->workflow() as $item) {
        //echo $item->user()->id()." - ".$item->data("duration") / 3600;
        var_export($item->user()->title());
        <br/>
    } */

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