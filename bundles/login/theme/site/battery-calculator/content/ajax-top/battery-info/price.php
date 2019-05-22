<?

$cell = $battery->cell();

<table class='pAkTlSYpeG' >
    <thead>
        <tr>
            <td></td>
            <td>Ячейка</td>
            <td>Батарея</td>
        </tr>
    </thead>
    
    if(app()->user()->checkAccess("admin")) {
        <tr>
            <td><b>Закупка</b></td>
            <td>{round($cell->pricePurchase($battery->count())->rur())} &#8381;</td>
            <td>{round($cell->pricePurchase($battery->count())->rur() * $battery->count())} &#8381;</td>
        </tr>
    }
    
    <tr>
        <td><b>Цена</b></td>
        <td>
            $old = $cell->priceSelling(1)->rurTxt();
            $new = $cell->priceSelling($battery->count())->rurTxt();
            if($old != $new) {
                <span class='strikethrough' >{$old}</span>
                <br/>
            }
            <span>{$new}</span>
        </td>
        <td>
            $old = (new \Infuso\Site\Price($cell->priceSelling(1)->usd() * $battery->count()))->rurTxt();
            $new = (new \Infuso\Site\Price($cell->priceSelling($battery->count())->usd() * $battery->count()))->rurTxt();
            if($old != $new) {
                <span class='strikethrough' >{$old}</span>
                <br/>
            }
            <span>{$new}</span>
        </td>
    </tr>
    <tr>    
        <td><b>Работа</b></td>
        <td>{round($cell->priceAssembly($battery->count())->rur())} &#8381;</td>
        <td>{round($cell->priceAssembly($battery->count())->rur() * $battery->count())} &#8381;</td>
    </tr>
</table>

<div class='price' ><span>Цена: {$battery->price()->rurTxt()}</span></div>