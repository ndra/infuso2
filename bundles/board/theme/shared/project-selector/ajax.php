<?

$projects = \Infuso\Board\Model\Project::all()
    ->join("Infuso\\Board\\Model\\Task","`Infuso\\Board\\Model\\Task`.`projectId` = `Infuso\\Board\\Model\\Project`.`id`")
    ->groupBy("`Infuso\\Board\\Model\\Project`.`id`")
    ->desc("max(Infuso\\Board\\Model\\Task.created)")
    ->visible();
    
<div class='TfFKQlQcVt' >
    foreach($projects as $project) {
        <div class='item' data:id='{$project->id()}' >{$project->title()}</div>
    }
</div>