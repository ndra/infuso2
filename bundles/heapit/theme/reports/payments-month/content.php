<? 

exec("/ui/shared");

<div class='ufpznnu2pf' >

    <h1>Отчет за {str_pad($month,2,0,STR_PAD_LEFT)}.{$year}</h1>

    $payments = \Infuso\Heapit\Model\Payment::all()
        ->eq("year(date)", $year)
        ->eq("month(date)",$month)
        ->asc("orgId")
        ->asc("date", true)
        ->limit(0);
        
    $bargains = \Infuso\Heapit\Model\Bargain::all()
        ->eq("year(paymentDate)",$year)
        ->eq("month(paymentDate)", $month)
        ->eq("status", \Infuso\Heapit\Model\Bargain::STATUS_INPROCESS)
        ->limit(0);

    
    // Сюда будем складывать данные
    $data = array();

    foreach($payments->copy()->eq("status",200) as $payment) {
        if((double) $payment->data("income")) {
            $data["income"][$payment->data("group")][] = $payment;
        }
        if((double) $payment->data("expenditure")) {
            $data["expenditure"][$payment->data("group")][] = $payment;
        }
    }
    
    // Функция рендера столбца данных
    
    $fn = function($data) {    
        foreach($data as $groupId => $payments) {        
            $group = \Infuso\Heapit\Model\PaymentGroup::get($groupId);
            exec("group", array(
                "bgcolor" => $group->reportColor(),
                "title" => $group->title(),
                "payments" => $payments,
                "inverse" => true,
            ));        
        }    
    };
    
    $statusPaid = \Infuso\Heapit\Model\Payment::STATUS_PAID;
    $statusPlan = array(\Infuso\Heapit\Model\Payment::STATUS_PUSHED, \Infuso\Heapit\Model\Payment::STATUS_PLAN);
    
    exec("total", array(
        "income" => $payments->copy()->eq("status", $statusPaid)->sum("income"),
        "incomePlan" => $payments->copy()->eq("status", $statusPlan)->sum("income"),
        "expenditure" => $payments->copy()->eq("status", $statusPaid)->sum("expenditure"),
        "expenditurePlan" => $payments->copy()->eq("status", $statusPlan)->sum("expenditure"),
        "bargains" => $bargains->eq("invoiced",0)->sum("amount"),
    ));
    
    <table style='width:100%;' >
        <tr>
            <td>
                exec("group", array(
                    "bgcolor" => "#ededed",
                    "title" => "Планируемый доход",
                    "payments" => $payments->copy()->eq("status", $statusPlan)->gt("income",0),
                ));  
                exec("group", array(
                    "bgcolor" => "#ddd",
                    "title" => "Сделки",
                    "bargains" => $bargains,
                ));  
                $fn($data["income"]);
            </td>
            <td>
                exec("group", array(
                    "bgcolor" => "#ededed",
                    "title" => "Планируемые расходы",
                    "payments" => $payments->copy()->eq("status", $statusPlan)->gt("expenditure",0),
                ));  
                $fn($data["expenditure"]);
            </td>
        </tr>
    </table>

</div>