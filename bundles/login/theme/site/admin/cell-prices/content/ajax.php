<?

<div>Розничная цена &mdash; {round($cell->priceSelling(1)->rur())} р.</div>
<div>Оптовая цена &mdash; {round($cell->priceSelling(99999999)->rur())} р.</div>
<div>Закупочная цена &mdash; {round($cell->pricePurchase()->rur())} р.</div>

$w = widget("googlechart");

$w->values("Количество", "Цена");

for($i = 0; $i < 500; $i ++) {
    $w->values($i, $cell->priceSelling($i)->rur());
}

$w->options("curveType", 'function');
$w->options("legend", array (
    "position" => 'none',
));
$w->options("hAxis", array (
    "title" => "Количество",
));
$w->options("vAxis", array (
    "title" => "Цена",
));
$w->exec();