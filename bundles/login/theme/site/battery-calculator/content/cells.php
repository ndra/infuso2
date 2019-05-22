<?

$cell = $battery->cell();

$format = function($d) {
    $d = round($d);
    return number_format($d, 0, ".", "&thinsp;");
};  

$w = widget("collapser");
$w->id("b44UquBg1V");
$w->addClass("x0gLb3EEqo c-celltable");
$w->keep();
$w->begin();

    $close = widget("collapser-head");
    $close->id("b44UquBg1V");
    $close->addClass("close");
    $close->begin();
        <div>
            echo "&#10060;";
        </div>
    $close->end();

    // Ячейка
    <table class='cell' >
        <thead>
            <tr>
                <th class='left' >
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/model")}' >Модель</span>
                    </div>
                </th>
                <th class='left' >
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/chemistry")}' >Химия</span>
                    </div>
                </th>
                <th class='left' >
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/type")}' >Тип</span>
                    </div>
                </th>
                <th>
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/price")}' >Цена, &#8381;</span>
                    </div>
                </th>
                <th>
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/energy-density")}' >Плотность<br/>Энергии<br/>Вт*ч/кг</span>
                    </div>
                </th>
                <th>
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/power-density")}' >Плотность<br/>Мощности<br/>Вт/кг</span>
                    </div>
                </th>
                <th>
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/price-per-kwh")}' >Стоимость<br/> за 1 кВт*ч, &#8381;</span>
                    </div>
                </th>
                <th>
                    <div>
                        <span data:tooltip='{service("tip")->get("battery-calculator/cell-table/price-per-100km")}' >Аммортизация<br/>на 100 км<br/>поездки, &#8381;</span>
                    </div>
                </th>
            </tr>
        </thead>
        foreach(\Infuso\Site\Model\BatteryCalculator\Cell::all()->eq("publish", true)->limit(0) as $n => $cc) {
            
            $class = $cc->id() == $cell->id() ? "active" : "";
            
            $battery = new \Infuso\Site\Battery(13, 100, $cc->id());
            $battery->setPower(278);
            
            <tr class='{$class}' data:cell={$cc->data("niceId")} >
            
                $preview = $cc->pdata("img")->preview(16,16);
                <td class='title' style='background-image: url({$preview});' >{$cc->vendor()->title()} {$cc->title()}</td>
                <td>
                    <a href='{$cc->chemistry()->url()}' >{$cc->chemistry()->title()}</a>
                </td>
                <td>
                    <a href='{$cc->size()->url()}' >{$cc->size()->title()}</a>
                </td>
                <td class='format'>{round($cc->priceSelling(1000)->rur())}</td>
                <td class='format'>{round($cc->energyDensity())}</td>
                <td class='format'>{round($cc->powerDensity())}</td>
                <td class='mono format' >{$format($cc->pricePerKWh()->rur())}</td>
                
                <td class='format' >{round($battery->pricePer100km(30)->rur())}</td>
                
            </tr>
        }
    </table> 

$w->end();   