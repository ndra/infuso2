<?

<div class='kpgxmnmut2' >

    <h1>Подтвердите оплату счета</h1>
    
    <div class='info' >
        <div class='billno' >
            echo "Счет №{$invoice->id()}";
        </div>
        <div>
            <i>Назначение платежа: </i> {$invoice->details()}
        </div>        
        <div>
            <i>Сумма: </i> {$invoice->sum()} {$invoice->currencyName()}
        </div>
    </div>    
    
    <div class='confirm' >
        <b>Оплатить данный заказ с вашего внутреннего счета?</b>
    </div>
    
    <form method='post'>
		app()->tm("/pay/button")->param( "text","Отмена")->exec();
        <input type='hidden' name='invoiceId' value='{$invoice->id()}' />
        <input type='hidden' name='cmd' value='pay:vendors:account:payDecline' />
    </form>
    
    <form method='post'>
		app()->tm("/pay/button")->param( "text","Оплатить")->exec();
        <input type='hidden' name='invoiceId' value='{$invoice->id()}' />
        <input type='hidden' name='cmd' value='pay:vendors:account:payAccept' />
    </form>
    
</div>