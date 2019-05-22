<?

$format = function($d) {
    $d = round($d, -2);
    return number_format($d, 0, ".", "&thinsp;");
};  

<div class='x5QSw1ScvqG' >

    <h2>Заказать батарею из элементов {$cell->vendor()->title()} {$cell->title()} </h2>
    
    <div>
        echo "Мы разработали для вас несколько различных батарей из ячеек {$cell->vendor()->title()} {$cell->title()}. ";
        echo "Вы можете заказать понравившуюся батарею или создать свою собственную, изменив количество ячеек. Выберите на наиболее подходящую батарею:";
    </div>
    <br>
    <br>

    $data = [
        [voltage => 36, kwh => .5],
        [voltage => 48, kwh => 1],
        [voltage => 72, kwh => 1.5],
        [voltage => 90, kwh => 2]];
        
    foreach($data as $item) {
        
        $serial = ceil($item["voltage"] / $cell->nominalVoltage());
        $parallel = ceil($item["kwh"] / ($cell->nominalCapacity() * $cell->nominalVoltage()) * 1000 / $serial);
        
        $battery = new \Infuso\Site\Battery($serial, $parallel, $cell->id());
        $battery->setPower(278);
        <div class='preset-container' >
            <a class='preset' href='{$battery->url()}' >
                <img class='cell' data:tooltip='Батарея из ячеек {e($cell->vendor()->title())} {e($cell->title())}' src='{$cell->pdata("img")->preview(30,30)}' />
                
                <div class="capacity" >{round($battery->capacity()/1000, 2)} кВт*ч</div>
                
                $range = round($battery->range(30));
                <div class='range-wrapper' >
                    <div class='range' data:tooltip='Пробег расчитывается для скорости 30 км/ч без педалей. Если помогать велосипеду педалями, пробег увеличится. На большей скорости пробег будет меньше. Данные приведены для сравнения. Реальный пробег зависит от множества факторов: скорости, уклона, покрытия дороги, ветра и т.д.' >до {$range} км</div>
                </div>
                
                <div class='weight' title='Вес батареи в сборе' >{round($battery->weight(), 1)} кг</div>

                <div class='price-container' >
                    <div class='price' >~ {$format($battery->price()->rur())} &#8381;</div>
                </div>
                
            </a>
            $power = round($battery->maxContinuousPower() / 1000, 1);
            <div class='voltage' >Напряжение {round($battery->nominalVoltage())}В</div>
            <div class="power" >Макс. мощность мотора $power кВт</div>
        </div>
        
    }

</div>

