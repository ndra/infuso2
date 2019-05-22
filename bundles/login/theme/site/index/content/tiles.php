<?

$size = 130;
$spacing = 10;

$cells = [
    [0,0,2,1],
    [1,1,3,3],
    [3,0,5,2],
    [6,0,8,2],
    [4,2,6,3],
    [2,0,3,1],
    [0,1,1,2],
    [0,2,1,3],
    [5,0,6,1],
    [5,1,6,2],
];

$groups = [];
foreach(\Infuso\Eshop\Model\Group::all()->eq("parent", 0)->active() as $group) {
    $groups[] = $group;
}

<div class='Zg8PRE2Jc3' >
    
    for($i = 0; $i < 8; $i ++) {
        for($j = 0; $j < 3; $j ++) {
            helper("<div>")
                ->addClass("item")
                ->style("left", $i * ($size + $spacing))
                ->style("top", $j * ($size + $spacing))
                ->style("width", $size)
                ->style("height", $size)
                ->exec();
        }
    }
    
    foreach($cells as $n => $cell) {
        
        $left = $cell[0] * ($size + $spacing);
        $top = $cell[1] * ($size + $spacing);
        $width = ($cell[2] - $cell[0]) * ($size + $spacing) - $spacing;
        $height = ($cell[3] - $cell[1]) * ($size + $spacing) - $spacing;
        
        $helper = helper("<div>")
            ->addClass("cell")
            ->style("left", $left)
            ->style("top", $top)
            ->style("width", $width)
            ->style("height", $height);
        
        $group = $groups[$n];
        if($group) {
            $helper
                ->style("background-image", "url(". $group->data("img") .")")
                ->param("content", $group->title());
        }

        $helper->exec();
    }

</div>