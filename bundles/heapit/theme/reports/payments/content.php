<? 

exec("/ui/shared");

$monthNames = array(
    "",
    "январь",
    "февраль",
    "март",
    "апрель",
    "май",
    "июнь",
    "июль",
    "август",
    "сентябрь",
    "октябрь",
    "ноябрь",
    "декабрь",
);

$payments = \Infuso\Heapit\Model\Payment::all();
<div class='z5qk1csmtq' >

    $payments->limit(0);
    $payments;
    
    // Сюда юудем складывать данные
    $data = array();
    
    // Данные по доходам (оплачено)
    $idata = $payments->copy()
        ->groupBy("`year`, `month`, `group`")
        ->eq("status", 200)
        ->select("month(`date`) as month, year(`date`) as `year`, sum(`income`) as `sum`, `group`");
    foreach($idata as $row) {
        $data[$row["year"]][$row["month"]]["income"][$row["group"]] = $row["sum"];
    }
    
    // Данные по доходам (счета)
    $ipdata = $payments->copy()
        ->groupBy("`year`, `month`")
        ->eq("status", array(50,100))
        ->select("month(`date`) as month, year(`date`) as `year`, sum(`income`) as `sum`");
    foreach($ipdata as $row) {
        $data[$row["year"]][$row["month"]]["income-plan"]["Планируемые доходы"] = $row["sum"];
    }
    
    // Данные по расходам
    $edata = $payments->copy()
        ->groupBy("`year`, `month`, `group`")
        ->eq("status", 200)
        ->select("month(`date`) as month, year(`date`) as `year`, sum(`expenditure`) as `sum`, `group`");
    foreach($edata as $row) {
        $data[$row["year"]][$row["month"]]["expenditure"][$row["group"]] = $row["sum"];
    }
    
    // Данные по расходам (счета)
    $epdata = $payments->copy()
        ->groupBy("`year`, `month`")
        ->eq("status", array(50,100))
        ->select("month(`date`) as month, year(`date`) as `year`, sum(`expenditure`) as `sum`");
        
    foreach($epdata as $row) {        
        $data[$row["year"]][$row["month"]]["expenditure-plan"]["Планируемые расходы"] = $row["sum"];        
    }

    // Вычисляем максимум дохода за все месяцы
    $max = 0;
    foreach($data as $yearData) {
        foreach($yearData as $monthData) {
            $max = max($monthData["income"] ? array_sum($monthData["income"]) : 0, $max);
        }        
    }
    
    // Для каждого года
    foreach($data as $year => $yearData) {
        <div class='year' >
            <div class='year-n' >{$year}</div>
            
            krsort($yearData);
            $monthCount = sizeof($yearData);
            
            $avgMonthData = array();
            
            foreach($yearData as $monthData) {   
            
                if($monthData["income"]) {
                    foreach($monthData["income"] as $group => $amount) {
                        $avgMonthData["income"][$group] += $amount / $monthCount;
                        $avgMonthData["income-total"][$group] += $amount;
                    }
                }
                if($monthData["expenditure"]) {
                    foreach($monthData["expenditure"] as $group => $amount) {
                        $avgMonthData["expenditure"][$group] += $amount / $monthCount;
                        $avgMonthData["expenditure-total"][$group] += $amount;
                    }
                }
            }
            
            exec("month", array(
                "month" => "За год",
                "data" => $avgMonthData,
                "max" => $max,
            ));
            
            <span style='margin-right:4%;' ></span>
            
            foreach(array_reverse($yearData, true) as $month => $monthData) {
                exec("month", array(
                    "month" => $monthNames[$month],
                    "data" => $monthData,
                    "max" => $max,
                ));
            }
        </div>
    }

</div>