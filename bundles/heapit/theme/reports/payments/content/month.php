<? 

$maxHeight = 200;

$colors = array(
    "#3366CC",
    "#DC3912",
    "#FF9900",
    "#109618",
    "#990099",
    "#3B3EAC",
    "#0099C6",
    "#DD4477",
    "#66AA00",
    "#B82E2E",
    "#316395",
    "#994499",
    "#22AA99",
    "#AAAA11",
    "#6633CC",
    "#E67300",
    "#8B0707",
    "#329262",
    "#5574A6",
    "#3B3EAC",
);

<div class='h4icank8er' style='height:{$maxHeight+20}px;' >

    // Приход

    <div style='position:absolute;bottom:20px;width:50%;' >
        ksort($data["income"]);    
        foreach($data["income"] as $key => $val) {
            $k = $val / $max;
            $height = round($k * $maxHeight);
            $h = helper("<div>");
            $h->style("background", $colors[$key]);
            $h->style("height", $height);
            $h->style("width", "100%");
            
            $title = \Infuso\Heapit\Model\PaymentGroup::get($key)->title();
            $title.= " ".$val." р.";
            $title.= " ".round($k*100)."%";
            $h->attr("title", $title);
            $h->exec();            
        }
    </div>
    
    // Расход
    
    <div style='position:absolute;bottom:20px;left:calc(50% + 1px);width:calc(50% - 1px);' >
        ksort($data["expenditure"]);
            foreach($data["expenditure"] as $key => $val) {
            $k = $val / $max;
            $height = round($k * $maxHeight);
            $h = helper("<div>");
            $h->style("background", $colors[$key]);
            $h->style("height", $height);
            $h->style("width", "100%");
            
            $title = \Infuso\Heapit\Model\PaymentGroup::get($key)->title();
            $title.= " ".$val." р.";
            $title.= " ".round($k*100)."%";
            $h->attr("title", $title);
            $h->exec();
            
        }      
        
    </div>
    
    <div class='month' >{$month}</div>
</div>