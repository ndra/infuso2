<?

$projects = \Infuso\Board\Model\Project::all();
<div class='TfFKQlQcVt' >
    foreach($projects as $project) {
        <div class='item' data:id='{$project->id()}' >{$project->title()}</div>
    }
</div>