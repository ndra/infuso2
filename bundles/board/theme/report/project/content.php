<?

use \Infuso\Board\Model;

<div class='H9IXl57L0B' >

    <form>
        widget("infuso\\board\\widget\\interval")
            ->nameFrom("from")
            ->valueFrom($from)
            ->nameTo("to")
            ->valueTo($to)
            ->exec();
        <input type='submit' value='Показать' class='g-button' />
    </form>
    
    $tasks = Model\Task::all()
        ->limit(0)
        ->orderByExpr("`changed` desc")
        ->geq("date(changed)", $from)
        ->leq("date(changed)", $to)
        ->neq("status", \Infuso\Board\Model\Task::STATUS_DRAFT)
        ->eq("projectId", $project->id())
        ->visible();
        
    <table class='task-list' >
        foreach($tasks as $task) {
            <tr>
                <td>{$task->id()}</td>
                <td class='text' >{\util::str($task->data('text'))->ellipsis(500)}</td>
                <td>{round($task->timeSpent() / 3600, 2)}</td>
                <td>{$task->timeScheduled()}</td>
                <td>{$task->statusText()}</td>
                <td>{$task->pdata("changed")->date()->num()}</td>
            </tr>
        }
        <tr class='bottom' >
            <td></td>
            <td>Итого</td>
            <td>{round($tasks->sum('timeSpent') / 3600, 2)}</td>
            <td>{$tasks->sum('timeScheduled')}</td>
            <td></td>
        </tr>
    </table>
        
    
</div>