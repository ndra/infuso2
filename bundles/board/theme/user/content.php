<?

lib::d3();

$tasks = \Infuso\Board\Model\Task::all()
    ->eq("responsibleUser", $user->id())
    ->geq("changed", \Infuso\Util\util::now()->shiftday(-60))
    ->visible();

<div class='tlajvftvvk' >
    
    $userData = $tasks->groupBy("projectId")
        ->orderByExpr("`spent` desc")
        ->having("spent > .1")
        ->select("projectId, sum(timeSpent) as `spent`");
    
    $json = array();
    foreach($userData as $item) {
        $project = \Infuso\Board\Model\Project::get($item["projectId"]);
        $json[] = array(
            "label" => $project->title(),
            "value" => round($item["spent"],1),
            "href" => (string) $project->url(),
        );
    }
    
    <div class='pie' data:data='{e(json_encode($json))}' ></div>
    
</div>