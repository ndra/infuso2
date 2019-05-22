<?

$cell = $battery->cell();

<div class='jhl0A6kb1x' >

    <div class='title' ><a href='{$cell->url()}' target='_blank' >Ячейка {$cell->vendor()->title()} {$cell->title()}</a></div>
    <br/>

    <a href='{$cell->url()}' target='_blank' style='display: block;' ><img src='{$cell->pdata("img")->preview(170,170)->fit()}' /></a>
    <a href='{$cell->url()}' target='_blank' >Подробнее об элементе</a><br/>
    if($spec = $cell->data("spec")) {
        <a href='{$spec}' target='_blank' >Спецификация</a>
    }
    
</div>