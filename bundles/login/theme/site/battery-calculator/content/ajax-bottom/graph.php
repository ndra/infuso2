<?

$cell = $battery->cell();

<div class='OtSdULN6ml' >

    <div class='graph' >
    
        if(!$cell->discharge()->count()) {
            return;
        }
        
        $min = 0;
        $max = $cell->maxContinuousCurrentDischarge();
        
        $w = widget("googlechart");
        $w->value("x", "Среднее напряжение на ячейке за цикл, В");
        $w->options("curveType", 'function');
        $w->options("legend", array (
            "position" => 'none',
        ));
        $w->options("hAxis", array (
            "title" => "Ток разряда, A",
        ));
        $w->options("vAxis", array (
            "title" => "Среднее напряжение на ячейке за цикл, В",
        ));
        
        for($x = $min; $x <= $max; $x += ($max - $min) / 100) {
            $w->value($x, $cell->voltage($x));
        }
        $w->exec();
    
    </div>
    
    // -----------------------------------------------------------
    
    <div class='graph' >
    
        $w = widget("googlechart");
        $w->value("x", "Отдаваемая емкость элемента");
        $w->options("curveType", 'function');
        $w->options("legend", array (
            "position" => 'none',
        ));
        $w->options("hAxis", array (
            "title" => "Ток разряда, A",
        ));
        $w->options("vAxis", array (
            "title" => "Отдаваемая емкость элемента",
        ));
        
        for($x = $min; $x <= $max; $x += ($max - $min) / 100) {
            $w->value($x, $cell->capacityAh($x));
        }
        $w->exec();
    
    </div>
    
    // --------------------------------------------------------------
    
    <div class='graph' >
    
        $w = widget("googlechart");
        $w->value("x", "Количество циклов");
        $w->options("curveType", 'function');
        $w->options("legend", array (
            "position" => 'none',
        ));
        $w->options("hAxis", array (
            "title" => "Ток разряда, A",
        ));
        $w->options("vAxis", array (
            "title" => "Количество циклов",
        ));
        
        for($x = $min; $x <= $max; $x += ($max - $min) / 100) {
            $w->value($x, $cell->cycles($x));
        }
        $w->exec();
    
    </div>

</div>