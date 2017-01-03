<?

<div class='PNMCr5It3R' >

    $payments = \Infuso\Heapit\Model\Payment::all()
        ->eq("date", $payment->data("date"));
    foreach($payments as $payment) {
        <div class='item' >
            <div>{$payment->org()->title()}</div>
            <div>{$payment->data("description")}</div>
            <div>{$payment->org()->title()}</div>
        </div>
    }

<div>