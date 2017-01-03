<?

<div class='J94g6FIowv c-similar-payments' data:id='{$payment->id()}' >

    $payments = \Infuso\Heapit\Model\Payment::all()
        ->eq("date", $payment->data("date"))
        ->neq("id", $payment->id());

    <div class='ajax-container' >
        exec("ajax", array(
            "payments" => $payments,
        ));
    </div>

</div>