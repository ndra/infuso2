<? 

<div class='bargain-list-zbp7jn8x8s' >

    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>Дата</td>
                <td>Организация</td>
                <td>Описание сделки</td>
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
                <td><a href='{$payment->url()}' >{$payment->data("income")}</a></td>
                <td><a href='{$payment->url()}' >{$payment->data("expenditure")}</a></td>
                <td><a href='{$payment->url()}' >{$payment->group()->title()}</a></td>
            </tr>
           
        }
    </table>
</div>