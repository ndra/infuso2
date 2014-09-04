<?

<div class='YkELjC2q38' >

    switch($status) {
        case "0":
            $title = "Бэклог";
            break;
        case "1":
            $title = "Выполняется";
            break;
        case "check":
            $title = "Выполнено / Отменено";
            break;
    } 
    
    if($group->exists()) {
        <h2>
            <span class='back' >{$title}</span>
            <span> / </span>
            <span class='title' >{$group->title()}</span>
        </h2>
    } else {
        <h2 class='title' >{$title}</h2>
    }

</div>