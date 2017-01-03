<?

<div class='PNMCr5It3R' >

    <div class='title' >Другие платежи на эту дату:</div>
    
    <table>
        foreach($payments as $payment) {
            <tr>
                <td>{$payment->org()->title()}</td>
                <td>{$payment->data("description")}</td>
                <td>
                    if($icome = $payment->data("income")) {
                        echo "+".$income;
                    }
                    if($expenditure = $payment->data("expenditure")) {
                        echo "-".$expenditure;
                    }
                </td>
            </tr>
        }
    </table>

<div>