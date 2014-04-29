<? 

$class = "iuh5t5jrex";
if($inverse) {
    $class.= " inverse";
}

<div class='{$class}' style='background:{$bgcolor}' >    

    // Расчитываем и выводим сумму
    $sum = 0;
    foreach($payments as $payment) {
        $sum += $payment->data("income") + $payment->data("expenditure");
    }

    <table class='header' >
        <tr>
            <td class='group-title' >{$group->title()}</td>
            <td class='sum' >&sum;={$sum} р.</td>
        </tr>
    </table>
    
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
    
</div>