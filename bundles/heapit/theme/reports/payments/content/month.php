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
$incomeTotal = array_key_exists("income-total", $data) ? array_sum($data["income-total"]) : 0;
$expenditure = array_sum($data["expenditure"]);
$expenditureTotal = array_key_exists("expenditure-total", $data) ? array_sum($data["expenditure-total"]) : 0;
<div class='h4icank8er' style='height:{$maxHeight+20}px;' >

    // Приход

    <div style='position:absolute;bottom:20px;width:45%;' >    
        
        if($incomeTotal) {
            <div class='total' >{round($income / 1000)} т./ мес.</div>
            <div class='total' >&sum; {round($incomeTotal / 1000)} т.</div>
        } else {
            <div class='total' >{round($income / 1000)} т.</div>
        }
    
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
            if($data["income-total"]) {
                $title.= " / ".$data["income-total"][$key]." р.";
            }
            $title.= " ".$percent."%";
            $h->attr("title", $title);
            $h->exec();            
        }
    </div>
    
    // Расход
    
    <div style='position:absolute;bottom:20px;left:55%;width:40%;' >
    
        if($expenditureTotal) {
            <div class='total' >-{round($expenditure / 1000)} т./ мес.</div>
            <div class='total' >&sum; -{round($expenditureTotal / 1000)} т.</div>
        } else {
            <div class='total' >-{round($expenditure / 1000)} т.</div>
        }
    
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
            if($data["expenditure-total"]) {
                $title.= " / ".$data["expenditure-total"][$key]." р.";
            }
            $title.= " ".$percent."%";
            $h->attr("title", $title);
            $h->exec();
            
        }      
        
    </div>
    
    // Прибыль
    
    <div style='position:absolute;bottom:20px;left:45%;width:10%;' >    
        $profit = round($income - $expenditure);
        $profitTotal = round($incomeTotal - $expenditureTotal);
        $height = $profit / $max * $maxHeight;
        $h = helper("<div>");
        $h->style("background", "gray");
        $h->style("outline", "1px solid white");
        $h->style("height", $height);
        $h->style("width", "100%");
        
        $title = $profit." р.";
        
        if($profitTotal) {
            $title.= " / ".$profitTotal." р.";
        }
        
        $h->attr("title", $title);
        
        $h->exec();
    </div>
    
    <div class='month' >{$month}</div>
</div>