<? 
<div class="payment-items-xqdd2vkc9s">
    $payments = \Infuso\Heapit\Model\Payment::all()->eq("orgID", $org->id());
    foreach($payments as $payment){
        <div class="item">
            <div class="head">
                <span>{$payment->pdata("orgID")->title()}</span>
                <span>{$payment->pdata("date")->num()}<span>
            </div>
            <div class="text">
                echo $payment->data("description");
            </div>
            <div class="sum">Сумма: {$payment->data("amount")} руб</div>
        </div>    
    }            
</div>