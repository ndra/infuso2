<?

use \Infuso\Board\Model;

<div class='id0xaej160' >
    
    $tasks = Model\Task::all()
        ->groupBy("projectId")
        ->limit(0)
        ->having("`spent` > 0")
        ->orderByExpr("`spent` desc")
        ->visible();
        
    <table>
        foreach($tasks->select("sum(`timeSpent`) as `spent`, sum(`timeScheduled`) as `scheduled`, `projectId`") as $row) {
            <tr>
                <td>{Model\Project::get($row["projectId"])->title()}</td>
                <td>{round($row["spent"] / 3600, 2)}</td>
                <td>{round($row["scheduled"], 2)}</td>
            </tr>
        }
    </table>
    
</div>