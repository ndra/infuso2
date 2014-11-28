<?

use \Infuso\Board\Model;

<div class='id0xaej160' >

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
        ->groupBy("projectId")
        ->limit(0)
        ->having("`spent` > 0")
        ->orderByExpr("`spent` desc")
        ->geq("date(changed)", $from)
        ->leq("date(changed)", $to)
        ->visible();
        
    <table>
        foreach($tasks->select("sum(`timeSpent`) as `spent`, sum(`timeScheduled`) as `scheduled`, `projectId`") as $row) {
            <tr>
                <td>
                    $href = action("infuso\\board\\controller\\report", "project", array("project" => $row["projectId"]))."?from={$from}&to={$to}";
                    <a href='{$href}' >{Model\Project::get($row["projectId"])->title()}</a>
                </td>
                <td>{round($row["spent"] / 3600, 2)}</td>
                <td>{round($row["scheduled"], 2)}</td>
            </tr>
        }
    </table>
    
</div>