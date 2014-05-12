<?

<div class='x55qv4lhb8m' >

    <a class='item' href='яяя' >Новая задача</a>

    foreach(\Infuso\Board\Model\TaskStatus::all() as $status) {
        if($status->id() != \Infuso\Board\Model\TaskStatus::STATUS_DRAFT) {
            $url = action("infuso\\board\\controller\\task","listtasks")->param("status", $status->id())->url();
            <a class='item' href='{$url}' >
                echo $status->title();
                $n = $status->visibleTasks()->count();
                <span class='count' >{$n}</span>
            </a>
        }
    }
    <i>
        <a href='#' menu:id='reports' class='item' >Отчеты</a>
        <a href='#' menu:id='conf' class='item' >Настройки</a>        
    </i>
</div>
    
// Субменю
<div class='x55qv4lhb8m-submenu' style='position:absolute;z-index:100;' >
    <div class='submenu' menu:id='reports' >
        <a class='item' href='#report-done' >Сделано сегодня</a>
        <a class='item' href='#report-projects' >Проекты</a>
        
        if(user::active()->checkAccess("board/showReportUsers")) {
            <a class='item' href='#report-workers' >Пользователи</a>
        }

        if(user::active()->checkAccess("board/showReportVote")) {
            <a class='item' href='#report-vote' >Голоса</a>
        }
        
        if(user::active()->checkAccess("board/showReportGallery")) {
            <a class='item' href='#report-gallery' >Галерея</a>
        }
        
    </div>
    <div class='submenu' menu:id='conf' >
    
        $url = action("infuso\\board\\controller\\projects")->url();
        <a class='item' href='{$url}' >Проекты</a>
        
        if(user::active()->checkAccess("board/showAccessList")) {
            <a class='item' href='#conf-access' >Доступ</a>
        }
        
        $url = action("infuso\\board\\controller\\conf")->url();
        <a class='item' href='{$url}' >Профиль</a>
        
    </div>
</div>

\Infuso\Plugins\Menu::create(".x55qv4lhb8m .item",".x55qv4lhb8m-submenu .submenu")->exec();
