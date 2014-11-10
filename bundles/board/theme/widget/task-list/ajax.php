<? 

use \Infuso\Board\Model;
use \Infuso\Board\Controller;

<div class="task-list-zjnu1r2ofp" data:sortable='{$status == "backlog" ? 1 : 0}' >

    <h2>{$group->title()}</h2>
    
    foreach($group->subgroups() as $subgroup) {
        <div class='group' data:id='{$subgroup->id()}' >{$subgroup->title()}</div>
    }
    
    foreach($group->tasks() as $task) {
        exec("task", array(
            "task" => $task,
        ));
    }

</div>