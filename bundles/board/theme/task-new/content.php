<?

<div class='sdqg1isQGi' data:group='{$group->id()}' >

    $create = array(
        "task" => true,
        "group" => app()->user()->checkAccess("board/createGroup"),
    );

    if(array_sum($create) > 1) {
        <div class='tabs-head' >
            if($create["task"]) {
                <div class='tab' >Создать задачу</div>
            }
            if($create["group"]) {
                <div class='tab' >Создать группу</div>
            }
        </div>
    }
    
    <div class='tabs' >
        if($create["task"]) {
            <div class='tab' >
                <h2 class='g-header' >Выберите проект</h2>
                exec("/board/shared/project-selector");
            </div>
        }
        if($create["group"]) {
            <div class='tab' >
                exec("group");
            </div>
        }
    </div>
    
</div>