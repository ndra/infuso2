<? 

<div class='g-toolbar c-toolbar swjdscw1a3' >

    // Быстрый поиск

    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->addClass("quicksearch")
        ->clearButton()
        ->exec();
        
    // Ответственные лица
        
    $values = array(
        0 => "Все менеджеры"
    );
    foreach(\User::all()->withRole("heapit:manager") as $user) {
        $values[$user->id()] = $user->title();
    }
    widget("\\infuso\\cms\\ui\\widgets\\select")
        ->values($values)
        ->addClass("user")
        ->fieldName("user")
        ->exec();
        
    // Статусы
        
    $values = array(
        "*" => "Все статусы"
    );
    foreach(\Infuso\Heapit\Model\Bargain::EnumStatuses() as $key => $val) {
        $values[$key] = $val;
    }
    widget("\\infuso\\cms\\ui\\widgets\\select")
        ->value("*")
        ->values($values)
        ->addClass("status")
        ->fieldName("status")
        ->exec();
        
    // Пейджер
        
    widget("\\infuso\\cms\\ui\\widgets\\pager")
        ->fieldName("pager")
        ->addClass("pager")
        ->exec();

</div>