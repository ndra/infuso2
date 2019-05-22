<?

$format = function($d) {
    $d = round($d, -2);
    return number_format($d, 0, ".", "&thinsp;");
}; 

$cell = $battery->cell();

$h = new helper();
$h->param("tag", "a");
$h->style("width", $width);
$h->style("height", $height);
$h->addClass("Efjz1xPdzl");
$h->attr("href", $battery->url());
$h->style("border", "10px solid ".$color);
$h->begin();
        
    <div class='bg-1' ></div>

    <img class='cell' data:tooltip='Батарея из ячеек {e($cell->vendor()->title())} {e($cell->title())}' src='{$cell->pdata("img")->preview(60,60)}' />
    
    <div class="capacity" >{round($battery->capacity()/1000, 2)} кВт*ч</div>
    
    <div class='title' >{$battery->title()}</div>
    
    $range = round($battery->range(30));
    <div class='range-wrapper' >
        <div class='range' data:tooltip='Пробег расчитывается для скорости 30 км/ч без педалей. Если помогать велосипеду педалями, пробег увеличится. На большей скорости пробег будет меньше. Данные приведены для сравнения. Реальный пробег зависит от множества факторов: скорости, уклона, покрытия дороги, ветра и т.д.' >пробег до {$range} км</div>
    </div>
    
    <div class='weight' title='Вес батареи в сборе' >{round($battery->weight(), 1)} кг</div>

    <div class='price-container' >
        <div class='price' >~ {$format($battery->price()->rur())} &#8381;</div>
    </div>
    
    $power = round($battery->maxContinuousPower() / 1000, 1);
    <div class='voltage' >Напряжение {round($battery->nominalVoltage())}В</div>
    <div class="power" >Макс. мощность мотора $power кВт</div>

$h->end();