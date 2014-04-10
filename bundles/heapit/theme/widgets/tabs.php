<? 

<div class='x8dhiuue82x' >
    
    <div class='head' >
        foreach($tabs as $n => $tab) {
            $h = helper("<span class='tab' ></span>");
            $h->param("content", $tab["title"]);
            if($n == 0) {
                $h->addClass("active");
            }
            $h->exec();
        }
    </div>
    
    <div class='content' >
        foreach($tabs as $tab) {
            <div class='tab' >{$tab["content"]}</div>
        }
    </div>    
    
</div>