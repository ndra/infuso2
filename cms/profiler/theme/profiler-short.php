<?

<div class='c8vWaICF5n' data:id='{$id}' >

    echo "Generated: ".round($data["variables"]["time"], 2)." sec.";
    <br/>
    echo "Page size : ".\util::bytesToSize1000($data["variables"]["content-size"]);
    <br/>
    echo "Memory: ".\util::bytesToSize1000($data["variables"]["memory-peak"])." / ".$data["variables"]["memory-limit"];
    
    $action = $data["variables"]["action"];
    if($action) {
        list($class, $id) = explode("/", $action);
        $record = service("ar")->get($class, $id);
        <div>Action: <a href='{$record->plugin("editor")->url()}}' >{$action}</a></div>
    }

</div>

