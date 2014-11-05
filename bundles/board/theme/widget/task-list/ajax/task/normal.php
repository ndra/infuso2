<? 

<div class='task i95bnu5fvm task-{$task->id()}' data:id='{$task->id()}' data:url='{$task->url()}' >

    <table>
        <tr>
            <td class='project' >{$task->project()->title()}</td>
            <td class='id' >{$task->id()}</td>
            <td class='text'>{$task->text()}</td>
        </tr>
    </table>
    
</div>