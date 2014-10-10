<? 

$class = "iuh5t5jrex";
if($inverse) {
    $class.= " inverse";
}

<div class='{$class}' style='background:{$bgcolor}' >    

    // Расчитываем сумму
    
    $sum = 0;
    if($payments) {
        foreach($payments as $payment) {
            $sum += $payment->data("income") + $payment->data("expenditure");
        }
    }
    if($bargains) {
        foreach($bargains as $bargain) {
            if(!$bargain->data("invoiced")) {
                $sum += $bargain->data("amount");
            }
        }
    }
    
    // Распределяем платежи по организациям
    if($payments) {
        $payments2 = $payments;
        $payments = array();
        foreach($payments2 as $payment) {
            $payments[$payment->org()->id()][] = $payment;
        }
    }
    
    // Выводим сумму

    <table class='header' >
        <tr>
            <td class='group-title' >{$title}</td>
            <td class='sum' >&sum;={$sum} р.</td>
        </tr>
    </table>
    
    if($payments) {
        <table class='payments' >
            foreach($payments as $orgId => $orgPayments) {
                
                $org = \Infuso\Heapit\Model\Org::get($orgId);
                
                $sum = 0;
                foreach($orgPayments as $payment) {
                    $sum += max($payment->data("income"),$payment->data("expenditure"));
                }
                
                <tr class='org' >
                    <td colspan='2' ></td>
                    <td>
                        <a href='{$org->url()}' >{$org->title()}</a>
                    </td>
                    <td class='sum' >{$sum} р.</td>
                </tr>
                
                foreach($orgPayments as $payment) {
                    <tr class='payment' >
                        <td class='date' >{$payment->pdata("date")->num()}</td>
                        $preview = $payment->pdata("userId")->userpic()->preview(16,16)->crop();
                        <td class='user' ><img src='{$preview}' /></td>
                        <td class='description' >
                            <a href='{$payment->url()}' >{$payment->data("description")}</a>
                            <span class='status' >{$payment->pdata("status")}</span>
                        </td>
                        <td class='sum' >{(int)max($payment->data("income"),$payment->data("expenditure"))} р.</td>
                    </tr>
                }
            }
        </table>
    }
    
    if($bargains) {
        <table class='bargains'  >
            foreach($bargains as $bargain) {
                $inject = $bargain->data("invoiced") ? "style='text-decoration:line-through;'" : "";
                <tbody {$inject}>
                    <tr>
                        <td class='date' >{$bargain->pdata("paymentDate")->num()}</td>
                        <td>
                            <a href='{$bargain->url()}' >{$bargain->org()->title()}</a>
                            <span class='status' >
                                echo $bargain->pdata("status");
                                if($bargain->data("invoiced")) {
                                    echo ", выставлен счет";
                                }
                            </span>
                        </td>
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