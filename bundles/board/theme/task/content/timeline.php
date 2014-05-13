<? 

<div class='hhraxv0jki' >

    echo $task->timeSpent();
    echo " + ";
    echo round($task->timeSpentProgress() / 3600, 2);

    $dayStart = \Util::now()->hours(9)->minutes(0)->seconds(0)->stamp();
    $dayEnd = \Util::now()->hours(19)->minutes(0)->seconds(0)->stamp();
    $dayLength = $dayEnd - $dayStart;
    $timeLog = $task->timeLog()->eq("date(begin)",\util::now()->date());
    <div style='position:relative;border:1px solid red;width:400px;' >
        foreach($timeLog as $item) {
        
            $start = ($item->pdata("begin")->stamp() - $dayStart) / $dayLength * 100;
            $length = ($item->pdata("end")->stamp() - $item->pdata("begin")->stamp()) / $dayLength * 100;
            $h = helper("<div>");
            $h->style(array(
                "position" => "absolute",
                "top" => 0,
                "left" => $start."%",
                "width" => $length."%",
                "height" => 50,
                "background" => "rgba(0,0,0,.3)"
            ));
            $h->begin();
            $h->end();
            //$end = $item->pdata("end")
        
            /*<div>
                echo $item->pdata("begin")->text();
                echo " - ";
                echo $item->pdata("end")->text();
            </div> */
        }
    </div>

</div>