<?

<table class='uot58zssqv' style='width:800px;' >

    <thead>
        <tr>
            <td>id</td>
            <td>Дата</td>
            <td>Задача</td>
            <td>План</td>
            <td>Потрачено</td>
            <td>Статус</td>
            <td>Тэги</td>
            <td>Заметка</td>
        </tr>
    </thead>
    
    $planned = 0;
    $spent = 0;

    foreach($tasks->limit(0) as $task) {        

		app()->tm("row")->param("task", $task)->exec();
        
        $planned += $task->timeScheduled();
        $spent += $task->timeSpent();
        
        foreach($task->subtasks()->limit(0) as $subtask) {        
			app()->tm("row")->param("task",$subtask)->exec();
        }  
        
    }
    
    <tr class='total' >
        <td></td>
        <td>Итого</td>
        <td>{$planned}</td>
        <td>{$spent}</td>
    </tr>
    
</table>