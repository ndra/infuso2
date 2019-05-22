<?

$cell = $battery->cell();

if(!$cell->exists()) {
    
    <div class='w4sNewrigR' >
        foreach(\Infuso\Site\Model\BatteryCalculator\BatteryPreset::all()->limit(6) as $n => $preset) {
            if($n >= 2) {
                <div class='preset' style='left: {($n - 2) * 280}px' >
                    widget("battery")
                        ->param("width", 270)
                        ->param("height", 270)
                        ->param("cell", $preset->data("cellId"))
                        ->param("serial", $preset->data("serial"))
                        ->param("parallel", $preset->data("parallel"))
                        ->param("title", $preset->title())
                        ->color($n - 1)
                        ->exec();
                </div>
            }
        }  
    </div>
    
} else {
    
    if(!$battery->isError()) {
        exec("/site/layout/shared");
        <div class='sax4eIlDVy' >
            exec("run");
            exec("graph");
        </div>
    }

}