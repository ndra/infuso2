<? 

<div class='payment-list-m0hv68kxht' >

    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>Дата</td>
                <td>Приход</td>
                <td>Расход</td>
                <td>Организация</td>
                <td>Назначение платежа</td>
                <td>Группа</td>
                <td>Статус</td>
            </tr>
        </thead>
        foreach($payments as $payment) {
            <tr>
                <td class='id' ><a href='{$payment->url()}' target='_blank' >{$payment->id()}</a></td>
                <td class='date' ><a href='{$payment->url()}' target='_blank' >{$payment->pdata("date")->num()}</a></td>
                <td class='income' ><a href='{$payment->url()}' target='_blank' >{\Infuso\Heapit\Utils::formatPrice($payment->data("income")) ?: ""}</a></td>
                <td class='expenditure' ><a href='{$payment->url()}' target='_blank' >{\Infuso\Heapit\Utils::formatPrice($payment->data("expenditure")) ?: ""}</a></td>
                <td><b><a href='{$payment->url()}' target='_blank' >{$payment->org()->title()}</a></b></td>
                <td><a href='{$payment->url()}' target='_blank' >{$payment->data("description")}</a></td>                
                <td class='group' ><a href='{$payment->url()}' target='_blank' >{$payment->group()->title()}</a></td>
                <td class="status paymentStatus-{$payment->data(status)}"><a href='{$payment->url()}' target='_blank' >{$payment->pdata("status")}</a></td>
            </tr>
           
        }
        
        <tr class='total' >
            <td colspan='2' style='text-align:right;' >итого</td>
            <td>{\Infuso\Heapit\Utils::formatPrice($payments->sum("income"))}</td>
            <td>{\Infuso\Heapit\Utils::formatPrice($payments->sum("expenditure"))}</td>
        </tr>
        
    </table>
</div>