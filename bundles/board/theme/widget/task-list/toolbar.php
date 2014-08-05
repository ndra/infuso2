<? 

<div class='c-toolbar task-toolbar-s88w4h5tpq' >

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

    <h2>{$title}</h2>

    if($status == "0" || $status == "check") {
        
        widget("\\infuso\\cms\\ui\\widgets\\textfield")
            ->addClass("quicksearch")
            ->clearButton()
            ->exec();
        
        widget("\\infuso\\cms\\ui\\widgets\\pager")
            ->fieldName("pager")
            ->addClass("pager")
            ->exec();
    }
    
</div>