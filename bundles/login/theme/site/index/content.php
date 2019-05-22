<?


<div class='mTDIBqStxW' >

    <h2>Заказать изготовление батареи для электровелосипеда</h2>
    
    <div style='margin-bottom: 20px;' >
        echo "Мы разработали для вас несколько различных батарей на основе популярных ячеек. ";
        echo "Вы можете заказать понравившуюся батарею или разработать свою собственную, изменив количество и тип ячеек. ";
        echo "Выберите на наиболее подходящую батарею:";
    </div> 
    
    <div class='presets' >
        foreach(\Infuso\Site\Model\BatteryCalculator\BatteryPreset::all()->limit(4) as $n => $preset) {
            <div class='preset' style='left: {$n * 280}px' >
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
    
    <h2>Интернет-магазин электровелосипедов</h2>
        
    exec("tiles");


</div>