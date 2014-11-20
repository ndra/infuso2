<?

$userId = app()->user()->id();

$projects = \Infuso\Board\Model\Project::all()
    ->leftJoin("Infuso\\Board\\Model\\Task","`Infuso\\Board\\Model\\Task`.`projectId` = `Infuso\\Board\\Model\\Project`.`id` and `Infuso\\Board\\Model\\Task`.`creator`={$userId}")
    ->groupBy("`Infuso\\Board\\Model\\Project`.`id`")
    ->desc("max(Infuso\\Board\\Model\\Task.created)")
    ->limit(0)
    ->visible();
    
<div class='TfFKQlQcVt' >
    foreach($projects as $project) {
        <div class='item' data:id='{$project->id()}' >{$project->title()}</div>
    }
</div>