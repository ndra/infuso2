<? 

exec("/ui/shared");

$payments = \Infuso\Heapit\Model\Payment::all();

<div class='z5qk1csmtq' >

    $payments->groupBy("`year`, `month`, `group`");
    $payments->limit(0);
    $xdata = $payments->select("month(`date`) as month, year(`date`) as `year`, sum(`income`) as `sum`, `group`");
    
    $data = array();
    foreach($xdata as $row) {
        $data[$row["year"]][$row["month"]][$row["group"]] = $row["sum"];
    }
    
    $max = 0;
    foreach($data as $yearData) {
        foreach($yearData as $monthData) {
            $max = max(array_sum($monthData), $max);
        }        
    }
    
    foreach($data as $year => $yearData) {
        <h2 class='g-header' >{$year}</h2>
        foreach(array_reverse($yearData, true) as $month => $monthData) {
            exec("month", array(
                "month" => $month,
                "data" => $monthData,
                "max" => $max,
            ));
        }
    }

</div>