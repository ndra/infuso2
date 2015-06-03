<? 

use \Infuso\Board\Model;
use \Infuso\Board\Controller;

<div class="task-list-zjnu1r2ofp" data:sortable='{$group->sortable() ? 1 : 0}' >

    // Хлебные крошки и заголовок
    <div class='toolbar' >
        <div class='title' >
            foreach($group->path() as $subgroup) {
                <span class='group' data:id='{$subgroup->id()}' >{$subgroup->title()}</span>
            }
            echo " / ";
            <span>{$group->title()}</span>
        </div> 
        <div class='pager' >
            //widget("infuso\\cms\\ui\\widgets\\pager")
             //   ->pages(10)
               // ->fieldName("page")
                //->exec();
        </div>
        /*<div class='view-mode' >
            echo "по группам / одним списком";
        </div>*/
    </div>
    
    // Список задач
    foreach($group->subgroups() as $item) {
        exec("item", array(
            "item" => $item,
            "group" => $group,
        ));
    }

</div>