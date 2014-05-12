<? 

<div class='mp31n7wmn2' >

    <h1>{$project->title()}</h1>
    
    foreach($this->accesses() as $access) {
        <div>
            echo $access->user()->title();
        </div>
    }

</div>