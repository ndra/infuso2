<? 

$colors = array(
    "#3366CC",
    "#DC3912",
    "#FF9900",
    "#109618",
    "#990099",
    "#3B3EAC",
    "#0099C6",
    "#DD4477",
    "#66AA00",
    "#B82E2E",
    "#316395",
    "#994499",
    "#22AA99",
    "#AAAA11",
    "#6633CC",
    "#E67300",
    "#8B0707",
    "#329262",
    "#5574A6",
    "#3B3EAC",
);

$bg = $colors[$n];

$percent = round($percent, 2);

<div class='e56siw3fuj' style='background:$bg linear-gradient(45deg,rgba(255,255,255,0),rgba(255,255,255,.3));width:{$width}%;' >

    <div>
        echo $text;
    </div>
    <div>
        echo \util::price($amount)." р.";
        if($percent) {
            echo " (".$percent."%)";
        }
    </div>

</div>