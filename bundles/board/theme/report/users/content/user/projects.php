<?

lib::d3();

$workflow = \Infuso\Board\Model\Workflow::all()
    ->eq("userId", $user->id())
    ->geq("begin", \Infuso\Util\util::now()->shiftday(-30))
    ->eq("status", 2);


<div class='tlajvftvvk' >
    
    $userData = $workflow
        ->JoinByField("taskId")
        ->groupBy("Infuso\\Board\\Model\\Task.projectId")
        ->select("projectId, sum(duration)  as `spent`");
    
    $json = array();
    foreach($userData as $item) {
        $project = \Infuso\Board\Model\Project::get($item["projectId"]);
        $spent = round($item["spent"] / 3600,1);
        if($spent <= .2 ) {
            continue;
        }
        $json[] = array(
            "label" => $project->title(),
            "value" => $spent,
            "href" => (string) $project->url(),
        );
    }
    
    <div class='pie' data:data='{e(json_encode($json))}' ></div>
    
</div>