<? 

use \Infuso\Board\Model;
use \Infuso\Board\Controller;

<div class="task-list-zjnu1r2ofp" data:sortable='1' >

    // Хлебные крошки и заголовок
    if($group->depth() > 1) {
        <div class='title' >
            foreach($group->path() as $subgroup) {
                <span class='group' data:id='{$subgroup->id()}' >{$subgroup->title()}</span>
            }
            echo " / ";
            <span>{$group->title()}</span>
        </div>
    }
    
    // Список задач
    foreach($group->subgroups() as $item) {
        exec("item", array(
            "item" => $item,
        ));
    }

</div>