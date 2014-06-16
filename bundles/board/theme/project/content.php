<? 

<div class='mp31n7wmn2' >

    <h1>{$project->title()}</h1>
    
    exec("form");
    
    foreach($project->accesses() as $access) {
        <div>
            echo $access->user()->title();
        </div>
    }

</div>