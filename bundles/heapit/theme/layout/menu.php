<? 

<div class='ncecpy3pn9 gradient-pattern' >

    $menu = array(
        (string) action("infuso\\heapit\\controller\\org") => "Контрагенты",
        (string) action("infuso\\heapit\\controller\\org", "add") => "+",
        
        (string) action("infuso\\heapit\\controller\\bargain") => "Сделки",
        (string) action("infuso\\heapit\\controller\\bargain", "add") => "+",
        
        (string) action("infuso\\heapit\\controller\\payment") => "Платежи",
        (string) action("infuso\\heapit\\controller\\payment", "add") => "+",
        
        "s" => "spacer",
        "p" => "spacer",
        "a" => "spacer",
        "c" => "spacer",
        "e" => "spacer",
        "r" => "spacer",
        
        "#reports" => "Отчеты",
        "#1" => "Настройки",
    );
    
    foreach($menu as $key => $val) {
        if($val == "spacer"){
            <span class="spacer"></span> 
        }else{
            <a class='item' href='{$key}' >{$val}</a>
            echo " ";    
        }
        
    }
    
    <span class="logout">Выход</span>
    <span class="me">Вы - Амаяьк Акопян</span>
    
</div>