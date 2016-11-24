<?

if($workflow->void()) {
    return;
}

$workflow2 = $workflow->copy()
    ->groupBy("date(begin)")
    ->desc("begin");

$days = array();
foreach($workflow2->select("date(begin) as `date`") as $row) {
    $days[] = $row["date"];
}

// Учитываем пустые дни, если задан диапазон
if($from && $to) {
    $current = \util::date($from)->date();
    $max = \util::date($to)->date();
    for($i = 0; $i < 1000; $i ++) {
        if(!in_array((string) $current, $days)) {
            $days[] = (string) $current;
        }
        $current->shiftDay(1);
        if((string) $current == $max) {
            break;
        }
    }
    usort($days, function($a, $b) {
        return \util::date($b)->stamp() - \util::date($a)->stamp();
    });
}

<div class='Roy1CZU9ev' >

    foreach($days as $day) {
        
        $day = \util::date($day)->date();
        
        <div class='day' >
        
            if($day->commercialWeekDay() < 6) {
                <div class='num' >{$day->text()}</div>
            } else {
                <div class='num' style='color:red; opacity: 1;' >{$day->text()}</div>
            }
            
            foreach($workflow->copy()->eq("date(begin)", $day) as $item) {
                
                $left = ($item->pdata("begin")->stamp() - $day->stamp()) / 3600 / 24 * 100;
                $width = ($item->duration()) / 3600 / 24 * 100;
                
                $title = $item->user()->title()." / ".round($item->data("duration") / 3600, 2);
                $title.= " (".$item->pdata("begin")->time();
                $title.= " — ";
                if($item->data("end")) {
                    $title.= $item->pdata("end")->time();
                }
                $title.= ")";
                
                $title.= " № ".$item->task()->id()." ";
                
                $title.= \util::str($item->task()->text())->ellipsis(100);
                
                $h = helper("<div>")
                    ->addClass("workflow-item")
                    ->style("width", $width."%")
                    ->style("left", $left."%")
                    ->attr("title", $title)
                    ->attr("data:taskId", $item->task()->id());
                    
                switch($item->data("status")) {
                    
                    case \Infuso\Board\Model\WorkFlow::STATUS_MANUAL:
                        $h->addClass("status-manual");
                        $h->style("left", ($left + $width)."%");
                        $h->style("width", 10);
                        break;
                        
                    case \Infuso\Board\Model\WorkFlow::STATUS_AUTO:
                        $h->addClass("status-auto");
                        break;
                        
                    case \Infuso\Board\Model\WorkFlow::STATUS_DRAFT:
                        $h->addClass("status-draft");
                        break;
                }
                    
                $h->exec();
                    
            }
        </div>
    }
    
    // Выводим часы
    for($i = 0; $i < 24; $i ++) {
        helper("<div>")
            ->param("content", $i)
            ->addClass("hour")
            ->style("left", ($i * 100 / 24)."%")
            ->exec();
    }
    
</div>