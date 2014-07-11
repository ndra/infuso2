<?

$items = \Infuso\Board\Model\Workflow::all()
    ->eq("date(begin)", \util::now()->date())
    ->eq("date(end)", \util::now()->date());
    
$containerWidth = 400;
$dayStart = \util::now()->date()->stamp();
    
<div class='v8IQ3WE8Rd' >
    foreach($items as $item) {
        $left = ($item->pdata("begin")->stamp() - $dayStart) / 3600 / 24 * $containerWidth;
        $width = ($item->pdata("end")->stamp() - $item->pdata("begin")->stamp()) / 3600 / 24 * $containerWidth;
        $w = helper("<div class='item' >");
        $w->style("left", $left);
        $w->style("width", $width);
        $w->begin();
        $w->end();
    }
    
    for($i = 0; $i < 24; $i++) {
        $w = helper("<div class='hour' >");
        $w->begin();
        $w->style("left", $containerWidth / 24 * $i);
            echo $i;
        $w->end();
    }
    
</div>