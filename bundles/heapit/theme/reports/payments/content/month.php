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

<a href='{$href}' class='h4icank8er' style='height:{$maxHeight+20}px;' >
 
    // Функция вывода данных по столбцу
    $fn = function($data,$dataTotal,$dataPlan) use ($max,$maxHeight,$colors) {    
    
        $sum = $data ? array_sum($data) : 0;
        $total = $dataTotal ? array_sum($dataTotal) : 0;
    
        if($sum) {
            if($total) {
                <div class='total' >{round($sum / 1000)} т./ мес.</div>
                <div class='total' >&sum; {round($total / 1000)} т.</div>
            } else {
                <div class='total' >{round($sum / 1000)} т.</div>
            }
        }
        
        // Данные по плану
        
        if($dataPlan) {
            foreach($dataPlan as $key => $val) {
                $k = $val / $max;
                $height = round($k * $maxHeight);
                $h = helper("<div>");
                $h->style("background", in_array($key, array("Планируемые доходы","Планируемые расходы")) ? "#ccc" : "#ededed");
                $h->style("height", $height);
                $h->style("width", "100%");
                
                $title = $key;
                $title.= " ".$val." р.";            
                $h->attr("title", $title);
                $h->exec();            
            }
        }
    
        // Данные по опдлаченным ссчетам
    
        if($data) {
            ksort($data);            
            foreach($data as $key => $val) {
                $k = $val / $max;
                $percent = $sum ? round($val / $sum * 100, 2) : 0;
                $height = round($k * $maxHeight);
                $h = helper("<div>");
                $h->style("background", $colors[$key]);
                $h->style("height", $height);
                $h->style("width", "100%");
                
                $title = \Infuso\Heapit\Model\PaymentGroup::get($key)->title();
                $title.= " ".$val." р.";
                if($dataTotal) {
                    $title.= " / ".$dataTotal[$key]." р.";
                }
                $title.= " ".$percent."%";
                $h->attr("title", $title);
                $h->exec();            
            }        
        }
    
    };

    // Приход
    <div style='position:absolute;bottom:20px;width:45%;' > 
        $fn($data["income"],$data["income-total"],$data["income-plan"]);        
    </div>
    
    // Расход    
    <div style='position:absolute;bottom:20px;left:55%;width:40%;' >    
        $fn($data["expenditure"],$data["expenditure-total"],$data["expenditure-plan"]);        
    </div>
    
    // Прибыль
    
    $income = $data["income"] ? array_sum($data["income"]) : 0;
    $incomeTotal = array_key_exists("income-total", $data) ? array_sum($data["income-total"]) : 0;
    $expenditure = $data["expenditure"] ? array_sum($data["expenditure"]) : 0;
    $expenditureTotal = array_key_exists("expenditure-total", $data) ? array_sum($data["expenditure-total"]) : 0;
        
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
</a>