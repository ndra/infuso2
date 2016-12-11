<?

<div class='qGloactNf0' >

    $log = $editor->item()->pdata("log");
    
    $max = 1;
    for($i = 0; $i < 24; $i ++) {
        $stamp = \Infuso\Core\Date::now()
            ->minutes(0)
            ->seconds(0)
            ->shift(-$i * 3600)
            ->stamp();
        $max = max($max, $log[$stamp]);
    }

    for($i = 0; $i < 24; $i ++) {
        
        $stamp = \Infuso\Core\Date::now()
            ->minutes(0)
            ->seconds(0)
            ->shift(-$i * 3600)
            ->stamp();
            
        $h = $log[$stamp];
        
        helper("<div>")
            ->addClass("column")
            ->style("height", ($h / $max * 100)."%")
            ->style("right", (100 / 24 * $i)."%")
            ->style("bottom", 0)
            ->attr("title", $h."/ч")
            ->exec();
    }

</div>