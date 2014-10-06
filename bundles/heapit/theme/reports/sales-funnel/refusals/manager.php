<? 

$descriptions = \Infuso\Heapit\Model\Bargain::enumRefusalDescription();

<div class='obnfaiu50c' >

    <h2 class='g-header' >{$title}</h2>
    
    $xbargains = $bargains->copy()
        ->eq("status", \Infuso\Heapit\Model\Bargain::STATUS_REFUSAL)
        ->groupBy("refusalDescription")
        ->orderByExpr("sum desc");
    $data = $xbargains->select("sum(amount) as sum, count(*) as count, refusalDescription");
    
    $max = array_reduce($data, function($value, $item) {
        return $value += $item["sum"];
    }, 0);
    
    $width = 200;
    
    foreach($data as $item) {
        <div class='row' >
        
            <div class='count' >{$item[count]}</div>
            <div class='sum' >{round($item[sum]/1000)}</div>
        
            helper("<div>")
                ->addClass("rowdata")
                ->style("background", "red")
                ->style("width", $item["sum"] / $max * $width)
                ->attr("title", $descriptions[$item["refusalDescription"]])
                ->param("content", $descriptions[$item["refusalDescription"]])
                ->exec();
        </div>
    }
    
</div>