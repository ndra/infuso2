<?

<div class='x55qv4lhb8m' >

    <a class='item new-task' href='{action("infuso\\board\\controller\\main")}' >Новая задача</a>
    <a class='item task-list' data:status='request' href='{action("infuso\\board\\controller\\main")}' >Заявки</a>
    <a class='item task-list' data:status='backlog' href='{action("infuso\\board\\controller\\main")}' >Бэклог</a>
    <a class='item task-list' data:status='inprogress' href='{action("infuso\\board\\controller\\main")}' >Выполняется</a>
    <a class='item task-list' data:status='check' href='{action("infuso\\board\\controller\\main")}' >Проверить</a>
    <a class='item task-list' data:status='done' href='{action("infuso\\board\\controller\\main")}' >Архив</a>
    <a class='item task-list' data:status='cancelled' href='{action("infuso\\board\\controller\\main")}' >Отменено</a>
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
