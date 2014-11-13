<?

<div class='tf92Pms9UG' >
    echo $task->id();
    echo ".";
    echo $task->project()->title();
    echo " / ";
    <span class='status' >{$task->statusText()}</span>
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