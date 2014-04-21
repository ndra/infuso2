<? 

<div class='obnfaiu50c' >

    <h2 class='g-header' >{$title}</h2>
    
    $xbargains = $bargains->copy()
        ->eq("status", \Infuso\Heapit\Model\Bargain::STATUS_REFUSAL)
        ->groupBy("refusalDescription")
        ->orderByExpr("sum desc");
    $data = $xbargains->select("sum(amount) as sum,refusalDescription");
    
    $total = 0;
    $max = 0;
    array_walk($data, function($item) use (&$total,&$max) {
        $total += $item["sum"];
        $max = max($max, $item["sum"]);
    });
    
    $signed = $bargains->eq("status", \Infuso\Heapit\Model\Bargain::STATUS_SIGNED)
        ->sum("amount");
    $total += $signed;
    $max = max($max, $signed);
    
    $amount = $total;
    $n = 0;
    
    exec("row", array(
        "amount" => $amount,
        "text" => "Обращения",
        "amount" => $total,
        "width" => 100,
        "n" => $n,
    ));
    
    foreach($data as $item) {
    
        $amount -= $item["sum"]; 
        $percent = round($item["sum"] / $total * 100, 2);
        $n++;  
    
        $dd = \Infuso\Heapit\Model\Bargain::enumRefusalDescription();    
        exec("row", array(
            "amount" => $item["sum"],
            "text" => $dd[$item["refusalDescription"]],
            "percent" => $percent,
            "n" => $n,
            "width" => round($amount / $total * 100, 2),
        ));        
    }
    
    $n++;
    
    <div class='hr' ></div>
    
    exec("row", array(
        "amount" => $amount,
        "percent" => $amount / $total * 100,
        "rest" => $amount,
        "text" => "Заключен договор",
        "width" => round($amount / $total * 100, 2),
        "n" => $n,
    )); 
    
</div>