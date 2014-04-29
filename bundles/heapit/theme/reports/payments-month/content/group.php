<? 

$class = "iuh5t5jrex";
if($inverse) {
    $class.= " inverse";
}

<div class='{$class}' style='background:{$bgcolor}' >    

    // Расчитываем и выводим сумму
    $sum = 0;
    if($payments) {
        foreach($payments as $payment) {
            $sum += $payment->data("income") + $payment->data("expenditure");
        }
    }
    if($bargains) {
        foreach($bargains as $bargain) {
            $sum += $bargain->data("amount");
        }
    }

    <table class='header' >
        <tr>
            <td class='group-title' >{$title}</td>
            <td class='sum' >&sum;={$sum} р.</td>
        </tr>
    </table>
    
    if($payments) {
        <table class='payment' >
            foreach($payments as $payment) {
                <tbody>
                    <tr>
                        <td class='date' >{$payment->pdata("date")->num()}</td>
                        <td>{$payment->org()->title()}</td>
                        <td>{max($payment->data("income"),$payment->data("expenditure"))} р.</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class='description' colspan='2' >{$payment->data("description")}</td>
                    </tr>
                </tbody>
            }
        </table>
    }
    
    if($bargains) {
        <table class='payment' >
            foreach($bargains as $bargain) {
                <tbody>
                    <tr>
                        <td class='date' >{$bargain->pdata("paymentDate")->num()}</td>
                        <td>{$bargain->org()->title()}</td>
                        <td>{$bargain->data("amount")} р.</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class='description' colspan='2' >{$bargain->data("description")}</td>
                    </tr>
                </tbody>
            }
        </table>    
    }
    
</div>