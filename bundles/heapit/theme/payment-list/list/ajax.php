<? 

$payments = \Infuso\Heapit\Model\Payment::all();
foreach($payments as $payment) {
    <div>
        <a href='{$payment->url()}' >{$payment->title()}</a>
    </div>
}