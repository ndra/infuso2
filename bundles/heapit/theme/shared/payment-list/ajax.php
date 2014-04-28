<? 

<div class='payment-list-m0hv68kxht' >

    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>Дата</td>
                <td>Организация</td>
                <td>Назначение платежа</td>
                <td>Статус</td>
                <td>Приход</td>
                <td>Расход</td>
                <td>Группа</td>
            </tr>
        </thead>
        foreach($payments as $payment) {
            <tr>
                <td><a href='{$payment->url()}' >{$payment->id()}</a></td>
                <td><a href='{$payment->url()}' >{$payment->pdata("date")->num()}</a></td>
                <td><a href='{$payment->url()}' >{$payment->org()->title()}</a></td>
                <td><a href='{$payment->url()}' >{$payment->data("description")}</a></td>
                <td class="paymentStatus-{$payment->data(status)}"><a href='{$payment->url()}' >{$payment->pdata("status")}</a></td>
                <td><a href='{$payment->url()}' >{$payment->data("income")}</a></td>
                <td><a href='{$payment->url()}' >{$payment->data("expenditure")}</a></td>
                <td><a href='{$payment->url()}' >{$payment->group()->title()}</a></td>
            </tr>
           
        }
    </table>
</div>