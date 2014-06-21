<? 

<div class='xx63vckg1k' >
    foreach($editor->menu() as $item) {
        $href = $item["href"];
        $h = helper("<a class='item' href='{$href}' >");
       
        // Подсвечиваем активный элемент
        if(trim($href,"/") == trim(\mod_url::current()->path(),"/")) {
            $h->addClass("active");
        }
        
        $h->begin();
            echo $item["title"];
            if($item["count"]) {
                <sup>{$item["count"]}</sup>
            }
        $h->end();
    }
</div>