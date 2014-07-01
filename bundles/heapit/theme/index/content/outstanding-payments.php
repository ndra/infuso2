<?

$payments = \Infuso\Heapit\Model\Payment::all()
    ->eq("status", array(\Infuso\Heapit\Model\Payment::STATUS_PLAN, \Infuso\Heapit\Model\Payment::STATUS_PUSHED))
    ->lt("date", \util::now()->date());
    
if(!$payments->count()) {
    return;
}

<div class='TsOdtTz4LT' >
    
    if(!$payments->void()) {
        <h2>Просроченные платежи:</h2>
        <table>
        
            $paymentsIncome = $payments->copy()->gt("income", 0)->asc("date");
            $count = $paymentsIncome->count();
            foreach($paymentsIncome as $payment) {
                <tr class='income' >
                    <td><a href='{$payment->url()}' >{$payment->org()->title()}</a></td>
                    <td class='price' >{$payment->data("income")}</td>
                    <td>{$payment->pdata("date")->left()}</td>
                </tr>
                $count--;
            }
            if($count > 0) {
                <tr>
                    <td>+ Еще {$count}</td>
                </tr>
            }
            
            $paymentsExpenditure = $payments->copy()->gt("expenditure", 0)->asc("date");
            $count = $paymentsExpenditure->count();
            foreach($paymentsExpenditure as $payment) {
                <tr class='expenditure'>
                    <td><a href='{$payment->url()}' >{$payment->org()->title()}</a></td>
                    <td class='price' >{$payment->data("expenditure")}</td>
                    <td>{$payment->pdata("date")->left()}</td>
                </tr>
            }
            if($count > 0) {
                <tr>
                    <td>+ Еще {$count}</td>
                </tr>
            }
            
        </table>
    }
    
    
</div>
