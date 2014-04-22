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

$income = array_sum($data["income"]);
$expenditure = array_sum($data["expenditure"]);

<div class='h4icank8er' style='height:{$maxHeight+20}px;' >

    // Приход

    <div style='position:absolute;bottom:20px;width:50%;' >
    
        <div class='total' >{round($income / 1000)} т.</div>
    
        ksort($data["income"]);    
        foreach($data["income"] as $key => $val) {
            $k = $val / $max;
            $percent = round($val / $income * 100, 2);
            $height = round($k * $maxHeight);
            $h = helper("<div>");
            $h->style("background", $colors[$key]);
            $h->style("height", $height);
            $h->style("width", "100%");
            
            $title = \Infuso\Heapit\Model\PaymentGroup::get($key)->title();
            $title.= " ".$val." р.";
            $title.= " ".$percent."%";
            $h->attr("title", $title);
            $h->exec();            
        }
    </div>
    
    // Расход
    
    <div style='position:absolute;bottom:20px;left:calc(50% + 1px);width:calc(50% - 1px);' >
    
        <div class='total' >{round($expenditure / 1000)} т.</div>
    
        ksort($data["expenditure"]);
        foreach($data["expenditure"] as $key => $val) {
            $k = $val / $max;
            $percent = round($val / $expenditure * 100, 2);
            $height = round($k * $maxHeight);
            $h = helper("<div>");
            $h->style("background", $colors[$key]);
            $h->style("height", $height);
            $h->style("width", "100%");
            
            $title = \Infuso\Heapit\Model\PaymentGroup::get($key)->title();
            $title.= " ".$val." р.";
            $title.= " ".$percent."%";
            $h->attr("title", $title);
            $h->exec();
            
        }      
        
    </div>
    
    <div class='month' >{$month}</div>
</div>