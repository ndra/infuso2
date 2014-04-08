<? 

<div class='ncecpy3pn9' >

    $menu = array(
        (string) action("infuso\\heapit\\controller\\org") => "Контрагенты",
        (string) action("infuso\\heapit\\controller\\org", "add") => "+",
        
        (string) action("infuso\\heapit\\controller\\bargain") => "Сделки",
        (string) action("infuso\\heapit\\controller\\bargain", "add") => "+",
        
        "payments" => "Платежи +",
        "reports" => "Отчеты",
        "1" => "натсройки",
    );
    
    foreach($menu as $key => $val) {
        <a class='item' href='{$key}' >{$val}</a>
        echo " ";
    }

</div>