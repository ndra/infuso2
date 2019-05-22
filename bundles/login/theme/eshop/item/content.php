<?

<div class='KIfNyeFbdN' >
    <h1>{$item->title()}</h1>
    <div>{$item->pdata("description")}</div>
    
    //echo $item->data("price");
    echo $item->priceObject()->rur();
    
    exec("/eshop/shared/buy");
    
</div>
