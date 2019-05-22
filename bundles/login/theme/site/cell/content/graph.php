<?

if(!$cell->discharge()->count()) {
    return;
}

<h2>Графики разряда {$cell->vendor()->title()} {$cell->title()}</h2>

<div class='pc6QMpq0BO' >

    // -----------------------------------------------------------

    <div>
        $min = 0;
        $max = $cell->maxContinuousCurrentDischarge();
       // $max = .2;
        
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
        $w->options("height", 400);
        
        for($x = $min; $x <= $max; $x += ($max - $min) / 400) {
            $w->value($x, $cell->voltage($x));
        }
        $w->exec();
    </div>
    
    // -----------------------------------------------------------
    
    <div>
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
        $w->options("height", 400);
        
        for($x = $min; $x <= $max; $x += ($max - $min) / 400) {
            $w->value($x, $cell->capacityAh($x));
        }
        $w->exec();
    </div>

// --------------------------------------------------------------

    <div>

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
        $w->options("height", 400);
        
        for($x = $min; $x <= $max; $x += ($max - $min) / 400) {
            $w->value($x, $cell->cycles($x));
        }
        $w->exec();
    
    </div>

</div>