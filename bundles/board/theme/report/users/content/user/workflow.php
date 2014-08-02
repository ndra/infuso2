<?

<div class='RR83prEY3c' >

    for($i = 0; $i < 30; $i ++ ) {
        
        $day = \util::now()->date()->shiftDay(-$i);
        
        <div class='day' >
        
            <div class='num' >{$day->text()}</div>
        
            $workflow = \Infuso\Board\Model\Workflow::all()
                ->eq("userId", $user->id())
                ->eq("date(begin)", $day)
                ->limit(0);
            foreach($workflow as $item) {
                
                $left = ($item->pdata("begin")->stamp() - $day->stamp()) / 3600 / 24 * 100;
                $width = ($item->data("duration")) / 3600 / 24 * 100;
                
                $h = helper("<div>")
                    ->addClass("workflow-item")
                    ->style("width", $width."%")
                    ->style("left", $left."%");
                    
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