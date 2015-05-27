<?

$userId = app()->user()->id();

$projects = \Infuso\Board\Model\Project::all()
    ->lastUsed()
    ->limit(10)
    ->search($search)
    ->visible();
    
<div class='TfFKQlQcVt' >
    foreach($projects as $project) {
        <div class='item' data:id='{$project->id()}' >{$project->title()}</div>
    }
</div>