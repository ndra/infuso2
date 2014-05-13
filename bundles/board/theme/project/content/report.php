<? 

lib::d3();

$tasks = $project->tasks();

<div class='aqmg2ttrto' >
    
    $userData = $tasks->groupBy("responsibleUser")
        ->geq("changed", \Infuso\Util\util::now()->shiftday(-60))
        ->orderByExpr("`spent` desc")
        ->having("spent > .1")
        ->select("responsibleUser,sum(timeSpent) as `spent`");
    
    $json = array();
    foreach($userData as $item) {
        $json[] = array(
            "label" => \User::get($item["responsibleUser"])->title(),
            "value" => round($item["spent"],1),
            "href" => (string) action("infuso\\board\\controller\\user", "index", array("id" => $item["responsibleUser"]))
        );
    }
    
    <div class='contributors' data:data='{e(json_encode($json))}' ></div>
    
</div>