<?

<div class='x55qv4lhb8m' >

    <a class='item new-task' >Новая задача</a>
    
    $group = new \Infuso\Board\Controller\Pseudogroup("");
    foreach($group->subgroups() as $sub) {
        <a class='item task-list' data:status='{$sub->id()}' href='{action("infuso\\board\\controller\\main", $sub->id())}' >{$sub->title()}</a>
    }

    <i>
        <a href='#' menu:id='reports' class='item' >Отчеты</a>
        <a href='#' menu:id='conf' class='item' >Настройки</a>        
    </i>
    
</div>
    
// Субменю
<div class='x55qv4lhb8m-submenu' style='position:absolute;z-index:100;width:100%;' >
    <div class='submenu dropdown' menu:id='reports' >

        <a class='item' href='{action("infuso\\board\\controller\\report","users")}' >Пользователи</a>

    </div>
    <div class='submenu dropdown' menu:id='conf' >
    
        if(user::active()->checkAccess("board/manager")) {
            $url = action("infuso\\board\\controller\\project")->url();
            <a class='item' href='{$url}' >Проекты</a>
        }
        
        if(user::active()->checkAccess("board/manager")) {
            $url = action("infuso\\board\\controller\\access")->url();
            <a class='item' href='{$url}' >Доступ</a>
        }
        
        $url = action("infuso\\board\\controller\\conf")->url();
        <a class='item' href='{$url}' >Профиль</a>
        
    </div>
    
</div>

\NDRA\Plugins\Menu::create(".x55qv4lhb8m .item",".x55qv4lhb8m-submenu .submenu")->exec();
