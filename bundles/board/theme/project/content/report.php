<? 

lib::d3();

$tasks = $project->tasks();

<div class='aqmg2ttrto' >
    
    $userData = $tasks->groupBy("responsibleUser")
        ->orderByExpr("`spent` desc")
        ->select("responsibleUser,sum(timeSpent) as `spent`");
    
    $json = array();
    foreach($userData as $item) {
        $json[] = array(
            "label" => \User::get($item["responsibnleUser"])->title(),
            "value" => round($item["spent"],1),
        );
    }
    
    <div class='contributors' data:data='{e(json_encode($json))}' ></div>
    
</div>