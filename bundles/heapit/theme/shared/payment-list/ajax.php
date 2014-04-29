<? 

<div class='payment-list-m0hv68kxht' >

    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>Дата</td>
                <td>Организация</td>
                <td>Назначение платежа</td>                
                <td>Приход</td>
                <td>Расход</td>
                <td>Группа</td>
                <td>Статус</td>
            </tr>
        </thead>
        foreach($payments as $payment) {
            <tr>
                <td class='id' ><a href='{$payment->url()}' >{$payment->id()}</a></td>
                <td class='date' ><a href='{$payment->url()}' >{$payment->pdata("date")->num()}</a></td>
                <td><b><a href='{$payment->org()->url()}' >{$payment->org()->title()}</a></b></td>
                <td><a href='{$payment->url()}' >{$payment->data("description")}</a></td>                
                <td class='income' ><a href='{$payment->url()}' >{$payment->data("income") ?: ""}</a></td>
                <td class='expenditure' ><a href='{$payment->url()}' >{$payment->data("expenditure") ?: ""}</a></td>
                <td class='group' ><a href='{$payment->url()}' >{$payment->group()->title()}</a></td>
                <td class="paymentStatus-{$payment->data(status)}"><a href='{$payment->url()}' >{$payment->pdata("status")}</a></td>
            </tr>
           
        }
        
        <tr class='total' >
            <td colspan='4' style='text-align:right;' >итого</td>
            <td>{$payments->sum("income")}</td>
            <td>{$payments->sum("expenditure")}</td>
        </tr>
        
    </table>
</div>