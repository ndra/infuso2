<? 

use \Infuso\Board\Model;
use \Infuso\Board\Controller;

<div class="task-list-zjnu1r2ofp" data:sortable='{$status == "backlog" ? 1 : 0}' >

    // Подгруппы
    foreach($group->path() as $subgroup) {
        <div class='group' data:id='{$subgroup->id()}' >{$subgroup->title()}</div>
    }

    <h2>{$group->title()}</h2>
    
    // Список задач
    foreach($group->subgroups() as $item) {
        exec("item", array(
            "item" => $item,
        ));
    }

</div>