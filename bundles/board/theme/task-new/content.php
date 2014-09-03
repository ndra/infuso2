<?

<div class='sdqg1isQGi' data:group='{$group->id()}' >

    <div class='tabs-head' >
        if($group->id()) {
            <div class='tab' >Создать задачу</div>
        }
        <div class='tab' >Создать группу</div>
    </div>
    
    <div class='tabs' >
        if($group->id()) {
            <div class='tab' >
                <h2 class='g-header' >Выберите проект</h2>
                exec("/board/shared/project-selector");
            </div>
        }
        <div class='tab' >
            exec("group");
        </div>
    </div>
    
</div>