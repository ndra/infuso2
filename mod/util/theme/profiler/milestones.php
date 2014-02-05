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
        
            $top = ($index%4) * 10;
            <div class='label' style='padding-top:{$top}px;top:45px;' >
                <span style='background:rgba(255,255,255,.5);z-index:1;position:relative;' >
                    echo $s[0];
                </span>
            </div>
        
        $h->end();
        
        $last = $time;            
        
    }
    
    foreach(mod_profiler::$operations as $key => $item) {
        $left = $item["s"] / $duration * $width;
        $w = $item["d"]  / $duration * $width;
        $name = $item["n"];
        $top = $key/2;
        <div class='segment' style='left:{$left}px;width:{$w}px;top:{$top}px;' title='{$name}'>
        </div>
    }

</div>