<?

$w = helper("<div>");
$w->addClass("u8fWiE6rDe user-bar");
$w->begin();

    $url = action("infuso\\heapit\\controller\\bargain");

    // Сделки сегодня
    $bargains = \Infuso\Heapit\Model\Bargain::all()
        ->eq("userId", $user->id())
        ->eq("status", array(0, 200, 500))
        ->eq("date(callTime)", \util::now()->date());
        
    if($n = $bargains->count()) {
        <a href='{$url}' >Сделки сегодня: {$n}</a>
    }
    
    // Сделки пропущены
    $bargains = \Infuso\Heapit\Model\Bargain::all()
        ->eq("userId", $user->id())
        ->eq("status", array(0, 200, 500))
        ->lt("date(callTime)", \util::now()->date());
        
    if($n = $bargains->count()) {
        <a href='{$url}' >Сделки пропущены: {$n}</a>
        $red = true;
    }
    
if($red) {
    $w->style("background", "red");
}

$w->end();