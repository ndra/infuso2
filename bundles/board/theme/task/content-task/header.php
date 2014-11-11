<?

<div class='tf92Pms9UG' >
    echo $task->pdata("status");
    echo $task->id();
    echo $task->project()->title();
    <table>
        <tr>
            <td class='left' >
                exec("/board/shared/task-tools"); 
            </td>
            <td class='right' >
                <span class='add-task' >еще</span>
            </td>
        </tr>
    </table>    
</div>