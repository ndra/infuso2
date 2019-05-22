<?

$format = function($d) {
    $d = round($d, -2);
    return number_format($d, 0, ".", "&thinsp;");
};  

<div class='FQvC1t9aEV' >
    
    <div class='help' >
        echo "&larr; Выберите ячейку, на основе которой будет изготовлена батарея";
        <br><br>
        echo "...или выберите готовый проект батареи &rarr;";
    </div>
    
    foreach(\Infuso\Site\Model\BatteryCalculator\BatteryPreset::all()->limit(2) as $n => $preset) {
        <div class='preset' style='left: {($n + 1) * 280}px' >
            widget("battery")
                ->param("width", 270)
                ->param("height", 270)
                ->param("cell", $preset->data("cellId"))
                ->param("serial", $preset->data("serial"))
                ->param("parallel", $preset->data("parallel"))
                ->param("title", $preset->title())
                ->color($n + 1)
                ->exec();
        </div>
    }    

</div>

