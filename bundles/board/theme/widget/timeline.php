<?

$days = $workflow->copy()->groupBy("date(begin)")->desc("begin")->select("date(begin) as `date` ");

<div class='Roy1CZU9ev' >

    foreach($days as $row) {
        
        $day = \util::date($row["date"])->date();
        
        <div class='day' >
        
            <div class='num' >{$day->text()}</div>
            
            foreach($workflow->copy()->eq("date(begin)", $day) as $item) {
                
                $left = ($item->pdata("begin")->stamp() - $day->stamp()) / 3600 / 24 * 100;
                $width = ($item->data("duration")) / 3600 / 24 * 100;
                
                $h = helper("<div>")
                    ->addClass("workflow-item")
                    ->style("width", $width."%")
                    ->style("left", $left."%")
                    ->attr("title", $item->user()->title()." / ".round($item->data("duration") / 3600, 2));
                    
                if($item->data("status") == 2) {
                    $h->addClass("status-2");
                } else {
                    $h->addClass("status-1");
                }
                    
                $h->exec();
                    
            }
        </div>
    }
    
</div>