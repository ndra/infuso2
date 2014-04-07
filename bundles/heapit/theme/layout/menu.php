<? 

<div class='ncecpy3pn9' >

    $menu = array(
        (string)\Infuso\Core\Action::get("infuso\\heapit\\controller\\org") => "Контрагенты",
        (string)\Infuso\Core\Action::get("infuso\\heapit\\controller\\org", "add") => "+",
        
        (string)\Infuso\Core\Action::get("infuso\\heapit\\controller\\bargain") => "Сделки",
        (string)\Infuso\Core\Action::get("infuso\\heapit\\controller\\bargain", "add") => "+",
        
        "payments" => "Платежи +",
        "reports" => "Отчеты",
        "1" => "натсройки",
    );
    
    foreach($menu as $key => $val) {
        <a class='item' href='{$key}' >{$val}</a>
        echo " ";
    }

</div>