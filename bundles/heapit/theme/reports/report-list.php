<? 

<div class='fhkprre088' >

    <div class='item' >
        $url = action("infuso\\heapit\\controller\\report", "salesFunnel");
        <a href='{$url}' class='sales-funnel' >Воронка продаж</a>    
    </div>

    <div class='item' >
        $url = action("infuso\\heapit\\controller\\report", "payments");
        <a class='payments' href='{$url}' >Платежи</a>
    </div>
    
    <div class='item' >
        $url = action("infuso\\heapit\\controller\\report", "clients");
        <a class='clients' href='{$url}' >Клиенты</a>
    </div>

</div>