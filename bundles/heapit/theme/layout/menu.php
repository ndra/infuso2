<? 

<div class='ncecpy3pn9 gradient-pattern main-menu' >

    $menu = array(
        array (
            "url" => (string) action("infuso\\heapit\\controller\\org"),
            "title" => "Контрагенты",
            "code" => "orgs",
        ), array (
            "url" => (string) action("infuso\\heapit\\controller\\org", "add"),
            "title" => "+",
            "code" => "org-add",
            "newtab" => true,
        ), array (
            "url" => (string) action("infuso\\heapit\\controller\\bargain"),
            "title" => "Сделки",
            "code" => "bargains",
        ), array (
            "url" => (string) action("infuso\\heapit\\controller\\bargain", "add"),
            "title" => "+",
            "code" => "bargain-add",
            "newtab" => true,
        ), array (
            "url" => (string) action("infuso\\heapit\\controller\\payment"),
            "title" => "Платежи",
            "code" => "payments",
        ), array (
            "url" => (string) action("infuso\\heapit\\controller\\payment", "add"),
            "title" => "+",
            "code" => "payment-add",
            "newtab" => true,
        ), array (
            "spacer" => true,
        ), array (
            "url" => (string) action("infuso\\heapit\\controller\\report"),
            "title" => "Отчеты",
            "code" => "reports",
            //"newtab" => true,
        ), array (
            "url" => (string) action("infuso\\heapit\\controller\\conf"),
            "title" => "Настройки",
            "code" => "conf",
            //"newtab" => true,
        ),
    );
    
    foreach($menu as $item) {
    
        if($item["spacer"]) {
            <span class="spacer" ></span> 
        } else {    
            $h = helper("<a class='item' href='{$item[url]}' >");
            $h->param("content", $item["title"]);
            if(tmp::param("main-menu") == $item["code"]) {
                $h->addClass("active");
            }
            
            if($item["newtab"]) {
                $h->attr("target", "_blank");
            }
            
            $h->exec();
        }
        
     }
    
    <span class="logout" >Выход</span>
    
    $url = (string) action("infuso\\heapit\\controller\\conf");
    <span class="me" >Вы — <a href='{$url}' >{\user::active()->title()}</a></span>
    
</div>