<?

$projects = \Infuso\Board\Model\Project::all()
    ->join("Infuso\Board\Model\Access", "`Infuso\Board\Model\Access`.`projectId` = `Infuso\Board\Model\Project`.`id`");

foreach($projects as $project) {
    <div>
        echo $project->title();
    </div>
}