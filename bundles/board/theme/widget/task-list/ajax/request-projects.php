<?

use \Infuso\Board\Model;

<div class='OhFHTNdpem' >

    $projects = Model\Project::all()
        ->visible()
        ->join("Infuso\Board\Model\Access", "`Infuso\Board\Model\Access`.`projectId` = `Infuso\Board\Model\Project`.`id`");
    
    foreach($projects as $project) {
        <div>
            echo $project->title();
            $count = Model\Task::all()
                ->eq("projectId", $project->id())
                ->eq("status", Model\Task::STATUS_REQUEST)
                ->count();
            echo " ($count)";
        </div>
    }

</div>