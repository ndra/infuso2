<?

widget("infuso\\cms\\ui\\widgets\combo")
    ->fieldName("projectId")
    ->callParams(array(
        "cmd" => "infuso/board/controller/project/listProjects"
    ))->exec();