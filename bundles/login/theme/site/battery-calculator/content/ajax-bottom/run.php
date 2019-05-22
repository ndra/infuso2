<?

exec("/site/layout/shared");

<div class='gyAh1jQPQ5' >

    $d2 = function($d) {
        return number_format($d, 2, ".", " ");
    };  
    
    <h2>Параметры батареи при при различных скоростях</h2>
    $consumption = array(
        "30" => 0.27,
        "40" => 0.57,
        "50" => 1.0,
        "60" => 1.7,
        "70" => 2.6,
        "80" => 3.8,
    );
    <table class='zz' >
        <thead> 
            <tr class='main' >
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/speed", "Калькулятор / Таблица пробега / Скорость")}' >Скорость,<br>км/ч</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/power-at-speed", "Калькулятор / Таблица пробега / Необходимая мощность")} '>Необходимая<br/>мощность,<br/>кВт.</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/range", "Калькулятор / Таблица пробега / Запас хода")}' >Запас хода</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/cycles", "Калькулятор / Таблица пробега / Циклов")}'>Циклов<br/>до 70%<br/>емкости</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/total-run", "Калькулятор / Таблица пробега / всего пробег")}'>Всего<br/>пробег, км</span></td>
                <td colspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/current", "Калькулятор / Таблица пробега / Ток")}' >Ток, А</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/discharge-rate", "Калькулятор / Таблица пробега / Скорость разряда")}' >Скорость<br/>разряда,<br/>C</span></td>
                <td colspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/voltage", "Калькулятор / Таблица пробега / Напряжение")}'>Напряжение, В</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/energy", "Калькулятор / Таблица пробега / Отдаваемая энергия")}'>Отдаваемая<br/>энергия,<br/>кВт*ч</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/heat", "Калькулятор / Таблица пробега / Нагрев батареи")}'>Нагрев<br/>батареи,<br/>Вт</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/price-per-100km", "Калькулятор / Таблица пробега / Стоимость юатареи на 100 км")}'>Стоимость<br>батареи<br>на 100 км (р.)</span></td>
                <td rowspan='2' ><span data:tooltip='{service("tip")->get("battery-calculator/run/energy-cost", "Калькулятор / Таблица пробега / Стоимость электроэнергии")}'>Стоимость<br/>электроэнергии<br/>100 км (р.)</span></td>
            </tr>
            <tr>
                <td>Ячейка</td>
                <td>Батарея</td>
                <td>Ячейка</td>
                <td>Батарея</td>
            </tr>
        </thead>
        
        $minRange = null;
        
        foreach($consumption as $speed => $power) {
            
            $battery->setPower($power * 1000);
            
            $class = "green";
            if($battery->current() > $battery->maxContinuousCurrentDischarge() / 2) {
                $class = "yellow";
            }
            if($battery->current() > $battery->maxContinuousCurrentDischarge()) {
                $class = "red";
            }
            
            $range = round($battery->range($speed));
            
            <tr class='{$class}' >
                
                <td class='speed' >{$speed} км/ч</td>
                
                if($class != "red") {
                    <td class='format' >{$power}</td>
                } else {
                    <td class='format' ><b>{$power}</b></td>
                }
                
                if($class != "red") {
                    
                    <td >
                    
                        $minRange = $minRange === null ? $range : $minRange;
                        $width = round($range / $minRange * 150);
                        if($class != "red") {
                            <div class='range' style='width:{$width}px;' >{$range} км</div>
                        }
                    
                    </td>
                    
                    <td class='format' >{round($battery->cycles())}</td>
                    <td class='format' >{round($battery->totalRange($speed))}</td>
                    <td class='format' >{$d2($battery->cellCurrent())}</td>
                    <td class='format' >{$d2($battery->current())}</td>
                    <td class='format' >{$d2($battery->rate())}</td>
                    <td class='format' >{$d2($battery->cellvoltage())}</td>
                    <td class='format' >{$d2($battery->voltage())}</td>
                    <td class='format' >{$d2($battery->capacity() / 1000)}</td>
                    <td class='format' >{round($battery->heat())}</td>
                    <td class='format' >{round($battery->pricePer100Km($speed)->rur())}</td>
                    <td class='format' >{round($power / $speed * 100 * 4.5)}</td>
                } else {
                    <td colspan='13' ><b>Перегрузка батареи!</b></td>    
                }
                
            </tr>

        }

    </table>
    
    exec("explanation");

</div>