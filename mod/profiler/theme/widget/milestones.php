<? 

$start = $GLOBALS["infusoStarted"];
$end = \Infuso\Core\Profiler::getVariable("stop");
$duration = $end - $start;

// Ширина полоски таймлайна
$width = 1000;

<div class='mgh1nqv4qw' >

    // Выводим майлстоуны на линию
    $last = 0;
    foreach(mod_profiler::getMilestones() as $index => $s) {
    
        $time = ($s[1] - $start) / $duration;
        $x = $width*($time - $last);
        $left = $last * $width;
        
        $h = tmp::helper("<div>")
            ->style("width",$x)
            ->style("left",$left)
            ->style("background","none")
            ->addClass("segment");
        $h->begin();
        
            $top = ($index%4) * 10 + 50;
            <div class='label' style='padding-top:{$top}px;top:45px;' >
                <span style='background:rgba(255,255,255,.5);z-index:1;position:relative;' >
                    echo $s[0];
                </span>
            </div>
        
        $h->end();
        
        $last = $time;            
        
    }
    
    // Сортируем операции так, чтобы самые длинные были впереди
    $ops = mod_profiler::$operations;
    usort($ops,function($a,$b) { 
        if($a["d"] < $b["d"]) {
            return -1;
        }
        if($a["d"] > $b["d"]) {
            return 1;
        }
        return 0;
    });
    $ops = array_values($ops);
    
    // Выводим операции
    $n = 0;
    foreach($ops as $key => $item) {
        $n++;
        $left = $item["s"] / $duration * $width;
        $w = $item["d"]  / $duration * $width;
        $name = util::str($item["n"])->esc()." ".$item["d"];
        $top = $item["d"]*1500;
        <div class='segment' style='left:{$left}px;width:{$w}px;top:{$top}px;' title='{$name}'>
        </div>
    }
    
</div>