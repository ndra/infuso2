<? 

exec("/ui/shared");

<div class='ufpznnu2pf' >

    <h1>Отчет за {str_pad($month,2,0,STR_PAD_LEFT)}.{$year}</h1>

    $payments = \Infuso\Heapit\Model\Payment::all()
        ->eq("year(date)", $year)
        ->eq("month(date)",$month)
        ->limit(0);
        
    $bargains = \Infuso\Heapit\Model\Bargain::all()
        ->eq("year(paymentDate)",$year)
        ->eq("month(paymentDate)", $month)
        ->eq("status", \Infuso\Heapit\Model\Bargain::STATUS_INPROCESS)
        ->limit(0);

    
    // Сюда юудем складывать данные
    $data = array();

    foreach($payments->copy()->eq("status",200) as $payment) {
        if($payment->data("income")) {
            $data["income"][$payment->data("group")][] = $payment;
        }
        if($payment->data("expenditure")) {
            $data["expenditure"][$payment->data("group")][] = $payment;
        }
    }
    
    // Функциф рендера столбца данных
    
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
    
    exec("total", array(
        "income" => $payments->copy()->eq("status", 200)->sum("income"),
        "incomePlan" => $payments->copy()->neq("status", 200)->sum("income"),
        "expenditure" => $payments->copy()->eq("status", 200)->sum("expenditure"),
        "expenditurePlan" => $payments->copy()->neq("status", 200)->sum("expenditure"),
        "bargains" => $bargains->sum("amount"),
    ));
    
    <table style='width:100%;' >
        <tr>
            <td>
                exec("group", array(
                    "bgcolor" => "#ededed",
                    "title" => "Планируемый доход",
                    "payments" => $payments->copy()->neq("status",200)->gt("income",0),
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
                    "payments" => $payments->copy()->neq("status",200)->gt("expenditure",0),
                ));  
                $fn($data["expenditure"]);
            </td>
        </tr>
    </table>

</div>