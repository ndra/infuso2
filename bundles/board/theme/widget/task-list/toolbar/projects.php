<? 
$projects = \Infuso\Board\Model\Project::all()->desc("id")->limit(10); 

<span class='projects-select'>    

    foreach($projects as $project) {
        $id = \util::id();
        $h = helper("<input value='{$project->id()}' type='checkbox' id='{$id}' />");
        $h->exec();
        <label for='{$id}' >{$project->title()}</label>
    }
</span>