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
        ->eq("projectId", $project->id())
        ->join("Infuso\Board\Model\Workflow", "`Infuso\Board\Model\Workflow`.`taskId` = `Infuso\Board\Model\Task`.`id`")
        ->eq("Infuso\Board\Model\Workflow.status", Model\Workflow::STATUS_MANUAL)
        ->groupBy("Infuso\Board\Model\Task.id")
        ->desc("changed")
        ->visible();
        
    if($from) {
        $tasks->geq("date(Infuso\Board\Model\Workflow.end)", $from);
    }
    
    if($to) {
        $tasks->leq("date(Infuso\Board\Model\Workflow.end)", $to);
    }
    
    $rows = $tasks->select("`Infuso\Board\Model\Task`.`id` as `id`, sum(`duration`) as `duration`");
        
    <table class='task-list' >
    
        <thead>
            <tr>
                <td>id</td>
                <td>Проект</td>
                <td class='text' >Описание задачи</td>
                <td>Потрачено, всего</td>
                <td>Потрачено, за период</td>
                <td>План</td>
                <td>Статус</td>
                <td>Изменено</td>
            </tr>
        </thead>
    
        foreach($rows as $row) {
            $task = Model\Task::get($row["id"]);
            <tr data:id='{$task->id()}' >
                <td>{$task->id()}</td>
                <td>{$task->project()->title()}</td>
                <td class='text' >{\util::str($task->data('text'))->ellipsis(300)}</td>
                <td>{round($task->timeSpent() / 3600, 2)}</td>
                <td>{round($row["duration"] / 3600, 2)}</td>
                <td>{$task->timeScheduled()}</td>
                <td class='status' >{$task->statusText()}</td>
                <td class='changed' >{$task->pdata("changed")->date()->num()}</td>
            </tr>
        }
        
        $idList = $tasks->idList();
        $spent = \Infuso\Board\Model\Task::all()->eq("id", $idList)->sum("timeSpent");
        
        <tr class='bottom' >
            <td></td>
            <td></td>
            <td>Итого</td>
            <td>{round($spent / 3600, 2)}</td>
            <td>{round($tasks->sum('Infuso\Board\Model\Workflow.duration') / 3600, 2)}</td>
            <td>{$tasks->sum('timeScheduled')}</td>
            <td></td>
            <td></td>
        </tr>
    </table>
        
    
</div>