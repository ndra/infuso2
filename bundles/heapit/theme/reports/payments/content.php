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

    $payments->groupBy("`year`, `month`, `group`");
    $payments->limit(0);
    $idata = $payments->select("month(`date`) as month, year(`date`) as `year`, sum(`income`) as `sum`, `group`");
    $edata = $payments->select("month(`date`) as month, year(`date`) as `year`, sum(`expenditure`) as `sum`, `group`");
    
    $data = array();
    foreach($idata as $row) {
        $data[$row["year"]][$row["month"]]["income"][$row["group"]] = $row["sum"];
    }
    
    foreach($edata as $row) {
        $data[$row["year"]][$row["month"]]["expenditure"][$row["group"]] = $row["sum"];
    }
    
    $max = 0;
    foreach($data as $yearData) {
        foreach($yearData as $monthData) {
            $max = max(array_sum($monthData["income"]), $max);
        }        
    }
    
    foreach($data as $year => $yearData) {
        <div class='year' >
            <h2 class='g-header' >{$year}</h2>
            
            $monthCount = sizeof($yearData);
            
            $avgMonthData = array();
            foreach($yearData as $monthData) {
                foreach($monthData["income"] as $group => $amount) {
                    $avgMonthData["income"][$group] += $amount / $monthCount;
                }
                foreach($monthData["expenditure"] as $group => $amount) {
                    $avgMonthData["expenditure"][$group] += $amount / $monthCount;
                }
            }
            
            exec("month", array(
                "month" => "За год",
                "data" => $avgMonthData,
                "max" => $max,
            ));
            
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