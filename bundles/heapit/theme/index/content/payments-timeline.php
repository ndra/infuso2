<?

$month = \util::now()->month();
$year = \util::now()->year();
$payments = \Infuso\Heapit\Model\Payment::all()
    ->neq("status", array(\Infuso\Heapit\Model\Payment::STATUS_DELETED))
    ->eq("month(date)", $month)
    ->eq("year(date)", $year);
    
$maxIncome = $payments->sum("income");
$maxExpenditure = $payments->sum("expenditure");
$max = max($maxIncome,$maxExpenditure);
$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31

<div class='h5LHKZDLp1' >

    $income = 0;
    $expenditure = 0;
    $height = 200;

    for($day = 1; $day <= $days; $day ++) {
        
        $income += $payments->copy()->eq("date", \util::date(mktime(0,0,0,$month,$day,$year)))->sum("income");
        $expenditure += $payments->copy()->eq("date", \util::date(mktime(0,0,0,$month,$day,$year)))->sum("expenditure");
        
        <div class='day' >
        
            if($max) {
                <div class='income' style='height:{$income / $max * $height}px;' ></div>
                <div class='expenditure' style='height:{$expenditure / $max * $height}px;' ></div>
            }
            <div class='number' >{$day}</div>
        
        </div>
        
    }
    
    $paid = $payments->copy()->eq("status",\Infuso\Heapit\Model\Payment::STATUS_PAID)->sum("income");
    $paidPercent = round($paid / $income * 100, 2);
    <div style='margin-top:20px;' >
        echo "Доход на данный момент: {$paid} р. ($paidPercent %)";
        <div style='width:400px;height:20px;background: #ededed;margin-top:5px;' >
            <div style='width:{$paidPercent / 100 * 400}px;background: green;height:20px;' ></div>
        </div>
    </div>
    
    $paid = $payments->copy()->eq("status",\Infuso\Heapit\Model\Payment::STATUS_PAID)->sum("expenditure");
    $paidPercent = round($paid / $income * 100, 2);
    <div style='margin-top:10px;' >
        echo "Расход на данный момент: {$paid} р. ($paidPercent %)";
        <div style='width:400px;height:20px;background: #ededed;margin-top:5px;' >
            <div style='width:{$paidPercent / 100 * 400}px;background: red;height:20px;' ></div>
        </div>
    </div>
    
</div>

